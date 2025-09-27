<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductApiController extends Controller
{
    /**
     * Display a listing of new arrival products.
     */
    public function newArrivals()
    {
        $products = Product::with(['colors', 'brand', 'category', 'sizes', 'deals'])
            ->where('new_arrival', true)
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
