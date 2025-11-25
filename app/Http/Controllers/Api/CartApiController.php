<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\CartRequest;
use App\Http\Requests\CartUpdateQuantityRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;

class CartApiController extends Controller
{
    /**
     * Add a product to the cart, or update quantity if it already exists in the cart.
     */
    public function add(CartRequest $request)
    {
        try {
            // find product along with highest discount by slug
            $product = Product::with(['bestDeal'])
                        ->where('slug', $request->product_slug)
                        ->isActive()
                        ->firstOrFail();

            if (!$product) {
                throw new \Exception("Product not found.");
            }

            // validate quantity
            $quantity = (int)$request->quantity;

            // limit max purchasable to 10 or available stock, whichever is lower
            $maxAllowed = min($product->stock,  config('site.cart.max_quantity')); 

            // if quantity is over stock, return error
            if ($quantity > $maxAllowed) {
                throw new \Exception("Quantity selected is over the stock.");
            }

            // check existing cart item by product id wether it is over stock
            // Note that one user can have one product with different color/size in the cart
            $sumQuantity = CartService::getCartCount($product->id);
            $cartCount = CartService::getCartCount();
            
            // Check if adding the new quantity would exceed the max allowed
            // if yes, adjust the quantity to fit the limit and set a warning message
            $warningMsg = '';
            if ($sumQuantity + $quantity > $maxAllowed) {
                $quantity  = $maxAllowed - $sumQuantity;
                if ($quantity <= 0) {
                    throw new \Exception("You have reached the maximum allowed quantity for this product in your cart.");
                }

                $warningMsg = "Only $quantity item(s) added to cart due to stock limit.";
            }

            CartService::addOrUpdateQuantityByProductColorSize($product->id, $request->color_id, $request->size_id, $quantity, $request->options);
            
            // Suggested items (get 3 random products for now, will change later)
            $suggested = Product::inRandomOrder()->take(3)->get();
            foreach ($suggested as $sgProduct) {
                $sgProduct->image = $sgProduct->thumbnail();
            }

            $cartCount += $quantity;

            // only apply the highest discount
            $priceAfterDeal = $product->price;
            $percentageOff = 0;
            if ($product->bestDeal->isNotEmpty()) {
                $percentageOff = $product->bestDeal[0]->percentage_off;
                $priceAfterDeal = $product->getPriceAfterDeal($percentageOff);
            }

            // Return a JSON response with success message and suggested items
            return response()->json([
                'success' => true,
                'popup' => [
                    'type' => 'success',
                    'product' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $product->thumbnail(),
                        'slug' => $product->slug,
                        'percentage_off' => $percentageOff,
                        'price_after_deal' => $priceAfterDeal,
                    ],
                    'suggested' => $suggested,
                    'message' => 'Item added to cart.' . ($warningMsg ? ' Warnign: ' . $warningMsg : ''),
                    'cartCount' => $cartCount,
                ],
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error adding to cart: ' . $e->getMessage());

            // Return a JSON response with error message
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the list of cart items with details.
     */
    public function cartList()
    {
        $cartItems = CartService::getCartItemsWithDetails();

        return response()->json([
                'success' => true,
                'cartItems' => $cartItems
            ]);
    }

    /**
     * Update the quantity of a cart item.
     */
    public function updateQuantity(CartUpdateQuantityRequest $request)
    {
        try {
            $quantity = (int)$request->quantity;

            // get current quantity by product id, color id, size id in cart
            $currentQtByProductColorSize = CartService::getCartCount(
                $request->product_id,
                $request->color_id,
                $request->size_id
            );

            $quantityDiff = $quantity - $currentQtByProductColorSize;

            if ($quantityDiff == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nothing to update in cart.'
                ]);
            }

            $product = Product::where('id', $request->product_id)
                            ->where('is_active', true)
                            ->firstOrFail();

            if (!$product) {
                throw ValidationException::withMessages(['product' => 'Product not found.']);
            }

            // limit max purchasable to 10 or available stock, whichever is lower
            $maxAllowed = min($product->stock,  config('site.cart.max_quantity')); 

            // if quantity is over stock, return error
            if ($quantity > $maxAllowed) {
                throw ValidationException::withMessages(['quantity' => 'Quantity selected is over the stock.']);
            }

            // check existing cart item by product id wether it is over stock
            // Note that one user can have one product with different color/size in the cart
            $sumQuantity = CartService::getCartCount($product->id);
            $cartCount = CartService::getCartCount();
            
            // Check if adding the new quantity would exceed the max allowed
            // if yes, adjust the quantity to fit the limit and set a warning message
            $warningMsg = '';
            if ($sumQuantity + $quantityDiff > $maxAllowed) {
                $quantity  = $maxAllowed - ($sumQuantity - $currentQtByProductColorSize);
                if ($quantity <= 0) {
                    throw ValidationException::withMessages(
                        ['quantity' => 'You have reached the maximum allowed quantity for this product in your cart.']
                    );
                }

                $warningMsg = "Only $quantity item(s) added to cart due to stock limit.";
            }

            CartService::setQuantityByProductColorSize(
                $request->product_id,
                $request->color_id,
                $request->size_id,
                $quantity
            );

            $cartCount += $quantity - $currentQtByProductColorSize;;

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'message' => 'Cart item quantity updated.',
                'warning' => $warningMsg,
                'quantityAllowed' => $quantity,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating cart quantity: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove an item from the cart.
     */    
    public function removeItem(int $productId, int $colorId, int $sizeId)
    {
        try {
            $cartCount = CartService::getCartCount();

            // remove item by product id, color id, size id
            // get deleted quantity to update cart count
            $delQuantity = CartService::removeByProductColorSize($productId, $colorId, $sizeId);

            $cartCount -= $delQuantity;

            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'message' => 'Item removed from cart.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
