<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use App\Models\Cart;

class CartService
{
    /**
     * Get total quantity of in cart
     * if passing productId, it will get total quantity of that product id in the cart
     */
    public static function getCartCount(int $productId=null): int
    {
        if (Auth::check()) {
            // For logged in user

            $conditions['customer_id'] = Auth::id();
            if ($productId) {
                $conditions['product_id'] = $productId;
            }
            $sumQuantity = Cart::where($conditions)
                ->sum('quantity');
        } else {
            // for guest user
            // get guest cart from cookies                
            $guestCart = json_decode(request()->cookie(config('site.cart.cookies_guest_cart'), '[]'), true);

            if ($productId){
                $sumQuantity = collect($guestCart)
                    ->where('product_id', $productId)
                    ->sum('quantity');
            } else {
                $sumQuantity = collect($guestCart)->sum('quantity');
            }
        }
        
        return $sumQuantity;
    }

    /**
     * Add or update an item in cart.
     */
    public static function addOrUpdateQuantityByProductColorSize(int $productId, int $colorId, int $sizeId, int $quantity, $options=null): void
    {
        $conditions['product_id'] = $productId;
        $conditions['color_id'] = $colorId;
        $conditions['size_id'] = $sizeId;

        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        if (Auth::check()) {
            // For logged in user
            $conditions['customer_id'] = Auth::id();
            
            // Use updateOrCreate to either update the quantity of existing item or create a new cart item
            $updateValues = [
                'quantity' => DB::raw('quantity + ' . $quantity), // increment quantity, let the database do the math instead of overriding the value
                'options' => $options,
            ];

            // update or create on cart table
            // find first row, if not found then create a new row
            $cart = Cart::firstOrCreate($conditions, ['quantity' => $quantity, 'options' => $options]);

            if (!$cart->wasRecentlyCreated) {
                $cart->increment('quantity', $quantity);
                $cart->update(['options' => $options]);
            }
        } else {
            // For guest user

            // get guest cart from cookies                
            $guestCart = json_decode(request()->cookie(config('site.cart.cookies_guest_cart'), '[]'), true);
            $guestExistingItem = collect($guestCart)->firstWhere($conditions);

            if ($guestExistingItem) {
                foreach ($guestCart as &$item) {
                    if ($item['product_id'] == $productId &&
                        $item['color_id'] == $colorId &&
                        $item['size_id'] == $sizeId
                    ) {
                        //update quality and options in cookies
                        $item['quantity'] += $quantity;
                        $item['options'] = $options;

                        break;
                    }                   
                }
            }  else {
                $guestCart[] = [
                    'product_id' => $productId,
                    'color_id'   => $colorId,
                    'size_id'    => $sizeId,
                    'quantity'   => $quantity,
                    'options'    => $options
                ];
            }

            // Store back to cookie for 7 days (60 mins × 24 hours × 7 days)
            Cookie::queue(config('site.cart.cookies_guest_cart'), json_encode($guestCart), 60 * 24 * 7);
        }
    }

    public static function addOrUpdateGuestCartToDB(): void
    {
        if (Auth::check()) {
            // get guest cart from cookies                
            $guestCart = json_decode(request()->cookie(config('site.cart.cookies_guest_cart'), '[]'), true);

            foreach ($guestCart as $key => $item) {
                self::addOrUpdateQuantityByProductColorSize(
                    $item['product_id'],
                    $item['color_id'],
                    $item['size_id'],
                    $item['quantity'],
                    $item['options']
                );

                // Remove item from $guestCart array
                unset($guestCart[$key]);
            }

            // store empty cart back to cookie for 7 days (60 mins × 24 hours × 7 days)
            Cookie::queue(config('site.cart.cookies_guest_cart'), json_encode([]), 60 * 24 * 7);
        }
    }

    /**
     * Remove an item from the cart.
     */
    /*public static function removeItem(array $cart, array $conditions): array
    {
        return array_values(array_filter($cart, function ($item) use ($conditions) {
            return !(
                $item['product_id'] == $conditions['product_id'] &&
                $item['color_id'] == $conditions['color_id'] &&
                $item['size_id'] == $conditions['size_id']
            );
        }));
    }*/
}
