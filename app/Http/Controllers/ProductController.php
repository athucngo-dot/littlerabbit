<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use \App\Models\Brand;
use \App\Models\Color;
use \App\Models\Category;
use \App\Models\Size;
use \App\Models\Material;

class ProductController extends Controller
{
    /**
     * Display the new arrivals page.
     */
    public function newArrivalsPage()
    {
        $brands = Brand::orderBy('name')->pluck('name', 'id');
        $colors = Color::orderBy('name')->pluck('name', 'id');
        $categories = Category::orderBy('name')->pluck('name', 'id');
        $sizes = Size::orderBy('id')->pluck('size', 'id');
        $materials = Material::orderBy('name')->pluck('name', 'id');

        return view('products.new-arrivals', compact('brands', 'colors', 'categories', 'sizes', 'materials'));
    }

    /**
     * Display the specified product by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
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
            $features = json_decode($features, true) ?? [];
        }

        // only apply the highest discount
        $priceAfterDeal = $product->price;
        if ($product->deals->isNotEmpty()) {
            // apply best deal to the price
            $priceAfterDeal = $product->getPriceAfterDeal($product->deals[0]->percentage_off);
        }

        $relatedProducts = $product->getRelatedProducts();

        // Frequently purchased together — as a simple fallback, use same brand
        $frequentlyPurchased = Product::where('brand_id', $product->brand_id)
            ->where('id', '!=', $product->id)
            ->isActive()
            ->with('images')
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // Prepare reviews for Alpine: include customer_name and minimal fields
        $reviews = $product->cachedReviews()->map(function ($r) {
            return [
                'id' => $r->id,
                'customer_name' => $r->customer?->name ?? 'Guest',
                'rv_rate' => (int) $r->rv_rate,
                'rv_comment' => $r->rv_comment,
                'created_at' => $r->created_at->toDateTimeString(),
            ];
        })->values(); // ->values() makes sure indexes are 0..n-1 for JSON

        // limit max purchasable to 10 or available stock, whichever is lower
        $maxQuantity = min($product->stock,  config('site.cart.max_quantity')); 
        
        return view('products.show', compact('product', 'priceAfterDeal', 'features', 'relatedProducts', 'frequentlyPurchased', 'reviews', 'maxQuantity'));
    }

    /**
     * Store a newly created review for a specific product.
     */
    public function storeReview(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rv_rate' => 'required|integer|min:1|max:5',
            'rv_comment' => 'nullable|string',
        ]);

        $review = $product->reviews()->create([
            'customer_id' => auth()->id() ?? 1, // replace 1 with guest or logged-in customer
            'rv_rate' => $validated['rv_rate'],
            'rv_comment' => $validated['rv_comment'] ?? '',
            'rv_quality' => 5,
            'rv_comfort' => 5,
            'rv_size' => 5,
            'rv_delivery' => 5,
        ]);

        return response()->json([
            'id' => $review->id,
            'customer_name' => $review->customer?->name ?? 'Guest',
            'rv_rate' => $review->rv_rate,
            'rv_comment' => $review->rv_comment,
        ]);
    }
}
