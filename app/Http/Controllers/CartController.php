<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Services\CartService;

use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Add a product to the cart, or update quantity if it already exists in the cart.
     */
    public function add(CartRequest $request)
    {
        try {
            // find product by slug
            $product = Product::where('slug', $request->product_slug)->firstOrFail();

            if (!$product) {
                throw new \Exception("Product not found.");
            }

            // validate quantity
            $quantity = (int)$request->quantity;
            $maxAllowed = $product->stock >= 10 ? 10 : $product->stock; // max 10 or stock if less than 10

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
            foreach ($suggested as $sgItem) {
                $img = $sgItem->images()->primary();
                $sgItem->image = $img ? $img->url : config('site.items_per_page');
            }

            // Prepare product image URL
            $productImg = $product->images()->primary();
            $productImgUrl = $productImg ? $productImg->url : config('site.items_per_page');

            $cartCount += $quantity;

            // Return a JSON response with success message and suggested items
            return response()->json([
                'success' => true,
                'popup' => [
                    'type' => 'success',
                    'product' => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => $productImgUrl,
                        'slug' => $product->slug,
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
}
