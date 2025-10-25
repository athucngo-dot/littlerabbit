<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Services\ProductService;

class ProductApiController extends Controller
{
    /**
     * Display a listing of new arrival products.
     */
    public function newArrivals(Request $request)
    {
        $products = ProductService::buildProductListQuery($request, 'newArrivals')
            ->latest('created_at')
            ->paginate(config('site.items_per_page'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }

    /**
     * Display a listing of discounted products.
     */
    public function deals(Request $request)
    {
        $products = ProductService::buildProductListQuery($request, 'deals')
            ->latest('created_at')
            ->paginate(config('site.items_per_page'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }

    /**
     * Display a listing of products by category slug
     */
    public function listByCategory(string $categorySlug, Request $request)
    {
        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            // Handle not found
            // Return a JSON response with error message
            return response()->json([
                'success' => false,
                'message' => 'Category ' . $categorySlug . ' does not exist.'
            ], 500);
        }

        $products = Product::with(['deals'])
            ->isActive()
            ->hasCategory([$category->id])
            ->latest('created_at')
            ->paginate(config('site.items_per_page_4_per_rows'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }

    /**
     * Display a listing of products by age group
     */
    public function listByAgeAndGender(string $ageGroup, string $gender, Request $request)
    {
        $products = Product::with(['sizes', 'deals'])
            ->isActive()
            ->hasGender($gender)
            ->hasAgeGroup($ageGroup)
            ->latest('created_at')
            ->paginate(config('site.items_per_page_4_per_rows'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }

    /**
     * Display a listing of accessory products.
     */
    public function accessories(Request $request)
    {
        $categoryIds = [19, 22, 23, 24, 25, 26 , 27, 29, 30, 31, 40, 42];
        
        $products = Product::isActive()
            ->hasCategory($categoryIds)
            ->latest('created_at')
            ->paginate(config('site.items_per_page_4_per_rows'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }

    /**
     * Display a listing of all active products.
     */
    public function allItems(Request $request)
    {
        $products = Product::isActive()
            ->latest('created_at')
            ->paginate(config('site.items_per_page_4_per_rows'))
            ->through(fn($product) => ProductService::transformProduct($product));

        return response()->json($products);
    }
}
