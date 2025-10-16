<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
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

        // apply best deal to the price
        $product->price_after_deals = $product->getPriceAfterDeal($product->deals->isNotEmpty() ? $product->deals[0]->percentage_off : null);

        // limit max purchasable to 10 or available stock, whichever is lower
        $product->max_quantity = min($product->stock,  config('site.cart.max_quantity')); 

        return $product;
    }

    /**
     * Build a product list query with optional filters and scope.
     * This can be used for different product listing endpoints.
     */
    public static function buildProductListQuery(Request $request, ?string $scope = null)
    {
        $gender     = $request->query('gender');
        $brandId    = $request->query('brand_id');
        $sizeId     = $request->query('size_id');
        $materialId = $request->query('material_id');
        $categoryId = $request->query('category_id');
        $colorId    = $request->query('color_id');
        $discount   = $request->query('discount');

        if ($scope === 'deals' && empty($discount)) {
            $discount = 'all'; // for deals page, default to show all with discount
        }

        $query = Product::with(['colors', 'brand', 'category', 'sizes', 'deals'])
            ->isActive()
            ->hasGender($gender)
            ->hasBrand($brandId)
            ->hasSize($sizeId)
            ->hasColor($colorId)
            ->hasMaterial($materialId)
            ->hasCategory($categoryId)
            ->hasDiscount($discount);

        // Apply scope-specific filters
        if ($scope === 'newArrivals') {
            $query->newArrivals();
        }

        return $query;
    }

    /**
     * Transform a Product model into a structured array for API response.
     */
    public static function transformProduct($product)
    {
        $dealsList = $product->deals->isNotEmpty()
            ? $product->deals->map(fn($deal) => [
                'name' => $deal->name,
                'percentage_off' => $deal->percentage_off,
            ])->values()
            : [];

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'image' => $product->images()->primary()->url ?? config('site.default_product_image'),
            'gender' => $product->gender,
            'colors' => $product->colors->pluck('name'),
            'brand' => $product->brand?->name,
            'category' => $product->category?->name,
            'sizes' => $product->sizes->pluck('size'),
            'deals' => $dealsList,
            'discount' => $product->deals->max('percentage_off') ?? 0,
            'price_after_deals' => $product->getPriceAfterDeal(),
        ];
    }
}
