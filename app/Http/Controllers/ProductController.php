<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\ProductService;
use App\Services\FilterService;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Category;
use App\Models\Size;
use App\Models\Material;

class ProductController extends Controller
{
    /**
     * Display the new arrivals page.
     */
    public function newArrivalsPage()
    {
        // Using FilterService to get filter options, then unpacking them to variables
        [
            'brands' => $brands, 
            'colors' => $colors, 
            'categories' => $categories, 
            'sizes' => $sizes, 
            'materials' => $materials
        ] = FilterService::getFilterOptions();

        return view('products.new-arrivals', compact('brands', 'colors', 'categories', 'sizes', 'materials'));
    }

    /**
     * Display the deals page.
     */
    public function dealsPage()
    {
        // Using FilterService to get filter options, then unpacking them to variables
        [
            'brands' => $brands, 
            'colors' => $colors, 
            'categories' => $categories, 
            'sizes' => $sizes, 
            'materials' => $materials
        ] = FilterService::getFilterOptions();

        return view('products.deals', compact('brands', 'colors', 'categories', 'sizes', 'materials'));
    }
    
    /**
     * Display products by age group and gender.
     */
    public function listByAgeAndGender(string $ageGroup, string $gender)
    {
        $listName = 'age-gender';
        return view('products.list', compact('listName', 'ageGroup', 'gender'));
    }

    /**
     * Display the accessories page.
     */
    public function accessoriesPage()
    {
        $listName = 'accessories';
        return view('products.list', compact('listName'));
    }   

    /**
     * Display the category page.
     */
    public function listByCategory(string $categorySlug)
    {
        $listName = 'category';
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));
        return view('products.list', compact('listName', 'categorySlug', 'categoryName'));
    }   

    /**
     * Display all items page.
     */
    public function allItemsPage()
    {
        $listName = 'all-items';
        return view('products.list', compact('listName'));
    }

    /**
     * Display the specified product by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $product = ProductService::getProductDetails($slug);
        
        // get related products, which is displayed in section "You may also like"
        $relatedProducts = $product->getRelatedProducts();

        // get recently viewed products, excluding the current product
        // displayed in section "Recently Viewed"
        $recentlyViewed = ProductService::retrieveRecentlyViewedProduct($product->id);
        ProductService::storeRecentlyViewedProduct($product);
        
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

        return view('products.show', compact('product', 'relatedProducts', 'recentlyViewed', 'reviews'));
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
