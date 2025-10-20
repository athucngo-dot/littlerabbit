<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
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
}
