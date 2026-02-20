<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Services\Stripe\StripePaymentService;

class CheckoutService
{
    /**
     * Constructor with dependency injection for StripePaymentService.
     */
    public function __construct(
        private readonly StripePaymentService $stripePaymentService
    ) {}

    /**
     * Create a Stripe payment intent for the current customer's cart items and the provided address data,
     * and return the client secret and order number for the payment intent.
     */
    public function createPaymentIntent(array $addressData): array
    {
        return DB::transaction(function () use ($addressData) {

            $customer = Auth::guard('customer')->user();

            // Retrieve the cart items for the current customer
            $cartItems = Cart::where('customer_id', $customer->id)->get();

            // Calculate the subtotal, shipping cost, and total amount for the order based on the cart items
            $subtotal = CartService::calculateSubtotal($cartItems);
            $shippingCost = CartService::calculateShippingCost($subtotal);
            $total = $subtotal + $shippingCost;

            // convert amount to cents
            $totalInCents = (int) round($total * 100);

            // Save the order and order address details in the database, 
            $order = OrderService::saveOrder(
                $cartItems,
                $subtotal,
                $shippingCost,
                $total,
                'pending',
                'standard'
            );

            // Save the order address details in the database
            // either by using an existing address from the customer's saved addresses or by using the provided address data for a new address.
            OrderService::saveOrderAddress($order->id, $addressData);

            // Create a Stripe payment intent for the order with the total amount, order ID, customer ID, and email,
            // and return the client secret and order number for the payment intent.
            $paymentIntent = $this->stripePaymentService->createPaymentIntent(
                amount: $totalInCents,
                orderId: $order->id,
                customerId: $customer->id,
                email: $customer->email
            );

            // Update the order with the Stripe payment intent ID to link the order with the corresponding payment intent in Stripe.
            $order->update([
                'stripe_payment_intent_id' => $paymentIntent->id,
            ]);

            return [
                'clientSecret' => $paymentIntent->client_secret,
                'orderNumber'  => $order->order_number,
            ];
        });
    }
}