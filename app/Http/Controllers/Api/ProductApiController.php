<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    /**
     * Display a listing of new arrival products.
     */
    public function newArrivals(Request $request)
    {
        $gender = $request->query('gender'); // get gender from URL
        $brandId = $request->query('brand_id'); // get brand_id from URL
        $sizeId = $request->query('size_id'); // get size_id from URL
        $materialId = $request->query('material_id'); // get material_id from URL
        $categoryId = $request->query('category_id'); // get category_id from URL
        $colorId = $request->query('color_id'); // get color_id from URL
        $discount = $request->query('discount'); // get discount from URL

        $products = Product::with(['colors', 'brand', 'category', 'sizes', 'deals'])
            ->newArrivals()
            ->isActive()
            ->hasGender($gender)
            ->hasBrand($brandId)
            ->hasSize($sizeId)
            ->hasColor($colorId)
            ->hasMaterial($materialId)
            ->hasCategory($categoryId)
            ->hasDiscount($discount)
            ->latest('created_at')
            ->paginate(config('site.items_per_page')) // server-side pagination
            ->through(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'image' => $product->images()->primary()?->url,
                    'gender' => $product->gender,
                    'colors' => $product->colors->pluck('name'),
                    'brand' => $product->brand?->name,
                    'category' => $product->category?->name,
                    'sizes' => $product->sizes->pluck('size'),
                    'discount' => $product->deals->max('discount_percentage') ?? 0,
                ];
            });

        return response()->json($products);
    }
}
