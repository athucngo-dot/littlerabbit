<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;

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
            $quantity = $request->quantity;
            $maxAllowed = $product->stock >= 10 ? 10 : $product->stock; // max 10 or stock if less than 10

            // if quantity is over stock, return error
            if ($quantity > $maxAllowed) {
                throw new \Exception("Quantity selected is over the stock.");
            }

            // check existing cart item by session/customerand product wether it is over stock
            // Note that one user can have one product with different color/size in the cart
            $conditions['product_id'] = $product->id;

            if (auth()->check()) {
                // Logged in user
                $conditions['customer_id'] = auth()->id();
            } else {
                // Guest user
                $conditions['session_id'] = $request->session()->getId(); // Laravel session ID;
            }

            // Check if adding the new quantity would exceed the max allowed
            // if so, adjust the quantity to fit the limit and set a warning message
            $warningMsg = '';
            $sumQuantity = Cart::where($conditions)->sum('quantity');
            if ($sumQuantity + $quantity > $maxAllowed) {
                $quantity  = $maxAllowed - $sumQuantity;
                if ($quantity <= 0) {
                    throw new \Exception("You have reached the maximum allowed quantity for this product in your cart.");
                }

                $warningMsg = "Only $quantity item(s) added to cart due to stock limit.";
            }

            // Find existing cart item by session/customer, product, color, size
            $conditions['color_id'] = $request->color_id;
            $conditions['size_id'] = $request->size_id;
            
            // Use updateOrCreate to either update the quantity of existing item or create a new cart item
            $updateValues = [
                'quantity' => DB::raw('quantity + ' . (int) $request->quantity), // increment quantity, let the database do the math instead of overriding the value
                'options' => $request->options ? json_encode($request->options) : null,
            ];

            $cartItem = Cart::updateOrCreate($conditions, $updateValues);

            // Suggested items (get 3 random products for now, will change later)
            $suggested = Product::inRandomOrder()->take(3)->get();
            foreach ($suggested as $sgItem) {
                $img = $sgItem->images()->primary();
                $sgItem->image = $img ? $img->url : config('site.items_per_page');
            }

            // Prepare product image URL
            $productImg = $product->images()->primary();
            $productImgUrl = $productImg ? $productImg->url : config('site.items_per_page');

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
