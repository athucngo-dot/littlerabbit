<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function homePage()
    {
        $featureProducts = Product::isActive()
            ->where('homepage_show', true)
            ->latest('created_at')
            ->take(4)
            ->get();

        $featureProducts->each(function ($product) {
            // Load primary image for each product
            $product->image = $product->images()->primary()->url ?? config('site.default_product_image'); 
        });

        return view('pages.home', compact('featureProducts'));
    }
}
