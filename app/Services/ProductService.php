<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class ProductService
{
    /**
     * Get product details by slug, 
     * including related relationships and calculated fields.
     */
    public static function getProductDetails(string $slug): Product
    {
        // query to load the product by slug and eager load related relationships used in the view
        $productQr = Product::with([
                'images' => function ($query) {
                    $query->orderByDesc('is_primary'); // primary comes first
                },
                'deals' => function ($query) {
                    $query->orderByDesc('percentage_off'); // best deal comes on top
                },
                'brand', 
                'colors',
                'sizes',
                'material',
                'reviews.customer' // eager load review->customer to show name
            ])
            ->where('slug', $slug)
            ->isActive();

        // Fetches the product from cache first
        // if not, then hit the DB
        $product = Cache::remember(
            "product_{$slug}_show", // cache key
            config('site.cache_time_out'),
            function() use ($productQr) {
                return $productQr->firstOrFail();
            }
        );

        // Make sure features is an array
        $features = $product->features;
        // Fallback in case it's still a JSON string
        if (is_string($features)) {
            $product->features = json_decode($features, true) ?? [];
        }

        // only apply the highest discount
        $product->price_after_deals = $product->price;
        if ($product->deals->isNotEmpty()) {
            // apply best deal to the price
            $product->price_after_deals = $product->getPriceAfterDeal($product->deals[0]->percentage_off);
        }

        // limit max purchasable to 10 or available stock, whichever is lower
        $product->max_quantity = min($product->stock,  config('site.cart.max_quantity')); 

        return $product;
    }
}
