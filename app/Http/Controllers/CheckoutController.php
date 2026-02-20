<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use App\Models\Cart;
use App\Models\Order;

use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        $cartItems = Cart::where('customer_id', Auth::guard('customer')->id())->get();

        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to your cart before proceeding to checkout.');
        }

        $customer = Auth::guard('customer')->user();
        $addresses = $customer->addresses;

        $subtotal = CartService::calculateSubtotal($cartItems);
        $shippingCost = CartService::calculateShippingCost($subtotal);
        $total = $subtotal + $shippingCost;

        return view('payments.checkout', 
            compact('customer', 'addresses', 'subtotal', 'shippingCost', 'total'));
    }

    /**
     * Payment intent
     */
    public function paymentIntent(CheckoutRequest $request, CheckoutService $checkoutService)
    {
        $response = $checkoutService->createPaymentIntent(
            $request->only([
                'address_id',
                'first_name',
                'last_name',
                'phone_number',
                'street',
                'city',
                'province',
                'postal_code',
                'country',
            ])
        );

        session([
            config('site.checkout_in_progress_session_key') => true
        ]);

        return response()->json($response);
    }

    /**
     * Handle payment succeeded
     */
    public function paymentSuccess($order_number)
    {
        $order = Order::where('order_number', $order_number)->first();

        $status = 'error';
        if (!$order) {
            $message = 'Order not found.';
            return view('payments.payment-success', compact('status', 'message'));
        }

        if ($order->customer_id !== Auth::guard('customer')->id()) {
            $message = 'Unauthorized access to this order.';
            return view('payments.payment-success', compact('status', 'message'));
        }

        if (in_array($order->status, ['pending', 'paid'])) {
            $status = 'success';
            $message = 'Payment is processing.';

            // Clear cart if checkout in progress
            $isCheckoutProgress = session()->get(config('site.checkout_in_progress_session_key'));
            if ($isCheckoutProgress) {
                //clear user's cart only once per checkout
                CartService::clearCart(Auth::guard('customer')->id());

                //remove the session flag
                session()->forget(config('site.checkout_in_progress_session_key'));
            }

            $payment = $order->payments()
                            ->latest()
                            ->first();

            $address = $order->addresses()->where('type', 'mailing')->first();
            
            Log::info('Payment is processing for order: ' . $order->order_number);
            return view('payments.payment-success', compact('status', 'message', 'order', 'payment', 'address'));
        }

        $status = 'error';
        $message = 'Something went wrong. Please try again.';
        return view('payments.payment-success', compact('status', 'message'));
    }
}
