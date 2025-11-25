<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\CartService;

use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display the cart page with cart items.
     */
    public function cart()
    {
        $cartItems = CartService::getCartItemsWithDetails();

        $allowCheckout = false;
        if (Auth::check() && count($cartItems) > 0) {
            $allowCheckout = true;
        }

        return view('payments.cart', compact('cartItems', 'allowCheckout'));
    }
}
