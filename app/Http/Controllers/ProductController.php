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
use App\Services\SearchService;

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
     * Display products by category.
     */
    public function listByCategory(string $categorySlug)
    {
        $listName = 'category';
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));
        return view('products.list', compact('listName', 'categorySlug', 'categoryName'));
    }   

    /**
     * Display products by deal.
     */
    public function listByDeal(string $dealSlug)
    {
        $listName = 'deal';
        $dealName = ucwords(str_replace('-', ' ', $dealSlug));
        return view('products.list', compact('listName', 'dealSlug', 'dealName'));
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
     * Handle product search requests.
     * Call search API and display results.
     */
    public function search(Request $request)
    {
        $query = trim($request->input('q', ''));
        $emptyQuery = ($query === '');
        
        $parser = new SearchService();
        $parsed = $parser->parse($query);
        $searchParams = $parser->rebuildParams($parsed);
        
        $listName = 'search';
        return view('products.list', compact('listName', 'searchParams', 'emptyQuery'));
    }
}
