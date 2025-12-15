<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Services\ProductService;

class CartService
{
    /**
     * Get total quantity of in cart
     * if passing productId, it will get total quantity of that product id in the cart
     * if passing productId, colorId and sizeId, it will get total quantity of that product-color-size combination in the cart
     */
    public static function getCartCount(int $productId=null, int $colorId=null, int $sizeId=null): int
    {
        $conditions = [];

        if ($productId !== null) {
            $conditions['product_id'] = $productId;

            if ($colorId !== null && $sizeId !== null) {
                $conditions['color_id'] = $colorId;
                $conditions['size_id']   = $sizeId;
            }
        }

        if (Auth::check()) {
            // For logged in user
            $conditions['customer_id'] = Auth::id();

            return Cart::where($conditions)->sum('quantity');
        }

        // for guest user
        // get guest cart from cookies
        $guestCart = collect(CartService::getCookieCart());

        // Apply the filters dynamically
        foreach ($conditions as $key => $value) {
            $guestCart = $guestCart->where($key, $value);
        }

        return $guestCart->sum('quantity');
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
            $guestCart = CartService::getCookieCart();
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

            // Store back to cookie
            CartService::setCookieCart($guestCart);
        }
    }

    public static function addOrUpdateGuestCartToDB(): void
    {
        if (Auth::check()) {
            // get guest cart from cookies                
            $guestCart = CartService::getCookieCart();

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

            // store empty cart back to cookie
            CartService::setCookieCart([]);
        }
    }

    public static function getCartItemsWithDetails(): array
    {
        $cartItemsDetails = [];

        if (Auth::check()) {
            // For logged in user
            $cartItems = Cart::where('customer_id', Auth::id())->get();

            foreach ($cartItems as $item) {
                $product = $item->product;
                $color = $item->color;
                $size = $item->size;

                if ($product) {
                    $cartItemsDetails[] = [
                        'product'   => ProductService::transformProduct($product),
                        'color_id'  => $color->id,
                        'color'     => $color->name,
                        'color_hex' => $color->hex,
                        'size_id'   => $size->id,
                        'size'      => $size->size,
                        'quantity'  => $item->quantity,
                        'options'   => $item->options,
                    ];
                }
            }

            return $cartItemsDetails;
        }

        // for guest user
        // get guest cart from cookies                
        $guestCart = CartService::getCookieCart();

        foreach ($guestCart as $item) {
            $product = Product::find($item['product_id']);
            $color = Color::find($item['color_id']);
            $size = Size::find($item['size_id']);

            if ($product) {
                $cartItemsDetails[] = [
                    'product'   => ProductService::transformProduct($product),
                    'color_id'  => $color->id,
                    'color'     => $color->name,
                    'color_hex' => $color->hex,
                    'size_id'   => $size->id,
                    'size'      => $size->size,
                    'quantity'  => $item['quantity'],
                    'options'   => $item['options'],
                ];
            }
        }

        return $cartItemsDetails;
    }

    public static function setQuantityByProductColorSize(int $productId, int $colorId, int $sizeId, int $quantity): void
    {
        if (Auth::check()) {
            // For logged in user
            $conditions['customer_id'] = Auth::id();
            $conditions['product_id'] = $productId;
            $conditions['color_id'] = $colorId;
            $conditions['size_id'] = $sizeId;
            
            // update quantity on cart table
            Cart::where($conditions)
                ->update(['quantity' => $quantity]);

            return;
        }

        // For guest user
        // get guest cart from cookies                
        $guestCart = CartService::getCookieCart();
        foreach ($guestCart as &$item) {
            if ($item['product_id'] == $productId &&
                $item['color_id'] == $colorId &&
                $item['size_id'] == $sizeId
            ) {
                //update quality in cookies
                $item['quantity'] = $quantity;

                break;
            }                   
        }

        // Store back to cookie
        CartService::setCookieCart($guestCart);        
    }

    // Get the difference in quantity for a cart item
    // e.g. if current quantity is 2, and new quantity is 5, return 3
    public static function getQuantityDiffInCart(int $productId, int $colorId, int $sizeId, int $quantity): int
    {
        // get current quantity in cart
        $currentQuantityInCart = CartService::getCartCount(
            $request->product_id,
            $request->color_id,
            $request->size_id
        );

        return $quantity - $currentQuantityInCart;
    }

    /**
     * Remove an item from the cart.
     */
    public static function removeByProductColorSize(int $productId, int $colorId, int $sizeId): int
    {
        if (Auth::check()) {
            // For logged in user
            $conditions['customer_id'] = Auth::id();
            $conditions['product_id'] = $productId;
            $conditions['color_id'] = $colorId;
            $conditions['size_id'] = $sizeId;
            
            // get current quantity by product id, color id, size id in cart
            $count = Cart::where($conditions)->sum('quantity');
            
            // delete item in cart by customar id, product id, color id, size id
            Cart::where($conditions)->delete();

            return $count;
        }

        // For guest user
        // get guest cart from cookies                
        $guestCart = CartService::getCookieCart();
        $count = 0;
        foreach ($guestCart as $key=>$item) {
            if ($item['product_id'] == $productId &&
                $item['color_id'] == $colorId &&
                $item['size_id'] == $sizeId
            ) {
                $count = $item['quantity'];
                unset($guestCart[$key]);

                break;
            }                   
        }
        
        // Reindex the array to avoid numeric gaps
        $guestCart = array_values($guestCart);

        // Store back to cookie
        CartService::setCookieCart($guestCart);  

        return $count;
    }

    /**
     * calculate subtotal of cart items
     */
    public static function calculateSubtotal($cartItems): float
    {
        $subtotal = 0.0;

        foreach ($cartItems as $item) {
            $productPrice = $item->product->getPriceAfterDeal();
            $quantity = $item->quantity;

            $subtotal += $productPrice * $quantity;
        }

        return number_format($subtotal, 2);
    }

    /**
     * Calculate shipping cost based on subtotal
     */
    public static function calculateShippingCost(float $subtotal): float
    {
        $freeShippingThreshold = config('site.cart.free_shipping_threshold');
        $shippingRate = config('site.cart.shipping_rate');

        if ($subtotal >= $freeShippingThreshold) {
            return 0.0;
        }

        return number_format(($subtotal * $shippingRate), 2);
    }

    /**
     * Clear cart for a customer
     */
    public static function clearCart(int $customerId): void
    {
        // For logged in user
        Cart::where('customer_id', $customerId)->delete();
    }

    /**
     * Helper: Get guest cart from cookies
     */
    private static function getCookieCart(): array
    {
        return json_decode(
            request()->cookie(config('site.cart.cookies_guest_cart'), '[]'), 
            true
        ) ?? [];
    }

    /**
     * Helper: Set guest cart to cookies
     */
    private static function setCookieCart(array $cart): void
    {
        // Store back to cookie for 7 days (60 mins × 24 hours × 7 days)
        Cookie::queue(
            config('site.cart.cookies_guest_cart'), 
            json_encode($cart), 
            config('site.cart.cookies_guest_cart_timeout')
        );
    }
}
