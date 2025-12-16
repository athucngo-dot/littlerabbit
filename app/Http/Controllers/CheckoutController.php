<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Services\CartService;
use App\Services\StripeService;
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
        if (!Auth::check()) {
            return redirect()->route('customer.login-register', ['ref' => 'cart']);
        }

        $cartItems = Cart::where('customer_id', Auth::id())->get();

        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items to your cart before proceeding to checkout.');
        }

        $customer = Auth::user();
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
    public function paymentIntent(CheckoutRequest $request, StripeService $stripe)
    {
        Log::info('go to paymentIntent Checkout Controller');

        if (!Auth::check()) {
            return redirect()->route('customer.login-register', ['ref' => 'cart']);
        }

        // Calculate totals
        $cartItems = Cart::where('customer_id', Auth::id())->get();
        $subtotal = CartService::calculateSubtotal($cartItems);
        $shippingCost = CartService::calculateShippingCost($subtotal);
        $total = $subtotal + $shippingCost;
        
        // Save order to database
        // shipping type is defaulted to 'standard' for now
        $order = OrderService::saveOrder($subtotal, $shippingCost, $total, 'pending', 'standard');
        
        // Save order products to database
        OrderService::saveOrderProducts($order->id, $cartItems);

        $addressData = $request->only([
            'address_id',
            'first_name',
            'last_name',
            'phone_number',
            'street',
            'city',
            'province',
            'postal_code',
            'country',
        ]);
        OrderService::saveOrderAddress($order->id, $addressData);

        // Create Stripe PaymentIntent
        $paymentIntent = $stripe->createPaymentIntent($total, $order->id);

        // Save PaymentIntent to order
        $order->update([
            'stripe_payment_intent_id' => $paymentIntent->id,
        ]);

        Log::info("Payment Intent - client secret: " . $paymentIntent->client_secret);
        return response()->json([
            'clientSecret' => $paymentIntent ->client_secret,
            'orderNumber' => $order->order_number,
        ]);
    }

    /**
     * Handle payment succeeded
     */
    public function paymentSuccess($order_number)
    {
        if (!Auth::check()) {
            return redirect()->route('customer.login-register', ['ref' => 'cart']);
        }

        $order = Order::where('order_number', $order_number)->first();

        $status = 'error';
        if (!$order) {
            $message = 'Order not found.';
            return view('payments.payment-success', compact('status', 'message'));
        }

        if ($order->customer_id !== Auth::id()) {
            $message = 'Unauthorized access to this order.';
            return view('payments.payment-success', compact('status', 'message'));
        }

        if ($order->status !== 'paid') {
            $message = 'Order not paid yet.';
            return view('payments.payment-success', compact('status', 'message'));
        }

        $status = 'success';
        $message = 'Payment successful.';

        $payment = $order->payments()
                        ->where('status', 'succeeded')
                        ->latest()
                        ->first();

        $address = $order->addresses()->where('type', 'mailing')->first();
        
        Log::info('Payment success for order: ' . $order->order_number);
        return view('payments.payment-success', compact('status', 'message', 'order', 'payment', 'address'));
    }
}
