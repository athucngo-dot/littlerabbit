<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Deal;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function homePage()
    {
        /**
         * get Feature list in Homepage
         */
        $featureProducts = Product::with(['deals'])
            ->isActive()
            ->where('homepage_promo', '>', 0)
            ->orderBy('homepage_promo')
            ->take(4)
            ->get();

        $featureProducts->each(function ($product) {            
            // get price after deals
            $product->price_after_deals = $product->getPriceAfterDeal();
        });

        /**
         * get promo deals in Homepage
         */
        $deals = Deal::where('homepage_promo', '>', 0)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->orderBy('homepage_promo')
                    ->get();

        return view('pages.home', compact('featureProducts', 'deals'));
    }
}
