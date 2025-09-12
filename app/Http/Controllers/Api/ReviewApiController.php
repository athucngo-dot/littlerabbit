<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;

class ReviewApiController extends Controller
{
    /**
     * Display a listing of the reviews for a specific product.
     */
    public function index($productSlug)
    {
        $reviews = Review::with('customer') // eager load customer
            ->whereHas('product', fn($q) => $q->where('slug', $productSlug))
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($r) => [
                'id' => $r->id,
                'rv_rate' => $r->rv_rate,
                'rv_comment' => $r->rv_comment,
                'customer_name' => ($r->customer?->first_name ?? '') . ' ' . ($r->customer?->last_name ?? ''), // pull from related customer
                'created_at' => $r->created_at->toDateTimeString(),
            ]);

        return response()->json($reviews);
    }

    /**
     * Store a newly created review for a specific product.
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rv_rate' => 'required|integer|min:1|max:5',
            'rv_comment' => 'required|string|max:500',
        ]);

        $review = $product->reviews()->create([
            'rv_rate' => $validated['rv_rate'],
            'rv_comment' => $validated['rv_comment'],
            'customer_name' => 'You', // or auth()->user()->name
        ]);

        return response()->json($review, 201);
    }
}
