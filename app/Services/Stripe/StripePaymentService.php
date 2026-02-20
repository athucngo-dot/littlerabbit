<?php

namespace App\Services\Stripe;

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\PaymentIntent as StripePaymentIntent;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Payment;
use App\Services\ProductService;

class StripePaymentService
{
    /**
     * Constructor with dependency injection for StripePaymentService.
     */
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe payment intent with the specified amount, order ID, customer ID, and email.
     * The amount is expected to be in cents.
     */
    public function createPaymentIntent(int $amount, int $orderId, int $customerId, string $email): StripePaymentIntent
    {
        return StripePaymentIntent::create([
            'amount' => $amount, // amount in cents
            'currency' => 'cad',
            'metadata' => [
                'order_id' => $orderId,
                'user_id'  => $customerId,
                'email'    => $email,
            ],
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);
    }

    /**
     * Handle a successful payment intent by updating the corresponding order status to 'paid', 
     * recording the payment details in the database, and reducing the stock quantities of the purchased products.
     * This method uses a database transaction to ensure data integrity and consistency throughout the process.
     */
    public function handleSucceeded(object $paymentIntent): void
    {
        DB::transaction(function () use ($paymentIntent) {

            $order = Order::where(
                'stripe_payment_intent_id',
                $paymentIntent->id
            )->lockForUpdate()->first();

            if (!$order || $order->status === 'paid') {
                return;
            }

            // Retrieve the latest charge associated with the payment intent to get detailed information about the payment method and card used.
            $intent = StripePaymentIntent::retrieve(
                $paymentIntent->id
            );

            $chargeId = $intent->latest_charge;

            if (!$chargeId) {
                throw new \RuntimeException(
                    "Missing latest_charge for {$paymentIntent->id}"
                );
            }

            $charge = Charge::retrieve($chargeId);

            $card = $charge->payment_method_details->card ?? null;

            // Record the payment details in the database, 
            // including information about the card used, the amount, currency, and the status of the payment.
            Payment::create([
                'customer_id' => $order->customer_id,
                'order_id' => $order->id,
                'provider' => 'stripe',
                'payment_intent_id' => $intent->id,
                'payment_method_id' => $charge->payment_method,
                'charge_id' => $charge->id,
                'provider_customer_id' => $intent->customer,
                'card_brand' => $card?->brand,
                'card_last_four' => $card?->last4,
                'card_exp_month' => $card?->exp_month,
                'card_exp_year' => $card?->exp_year,
                'amount' => $intent->amount,
                'currency' => $intent->currency,
                'status' => 'succeeded',
                'paid_at' => now(),
                'receipt_url' => $charge->receipt_url,
            ]);

            // Update the order status to 'paid' and set the paid_at timestamp to the current time.
            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            // Reduce the stock quantities of the purchased products
            ProductService::reduceStockQuantities($order->id);
        });
    }

    /**
     * Handle a failed payment intent by updating the corresponding order status to 'failed' and recording the failure details in the database.
     * This method uses a database transaction to ensure data integrity and consistency throughout the process.
     */
    public function handleFailed(object $paymentIntent): void
    {
        DB::transaction(function () use ($paymentIntent) {

            $order = Order::where(
                'stripe_payment_intent_id',
                $paymentIntent->id
            )->lockForUpdate()->first();

            if (!$order || $order->status === 'paid') {
                return;
            }

            // Update the order status to 'failed' and set the failed_at timestamp to the current time.
            $order->update([
                'status' => 'failed',
                'failed_at' => now(),
            ]);

            // Record the payment failure details in the database, including the failure code and message provided by Stripe.
            Payment::create([
                'customer_id' => $order->customer_id,
                'order_id' => $order->id,
                'provider' => 'stripe',
                'payment_intent_id' => $paymentIntent->id,
                'status' => 'failed',
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'failure_code' => $paymentIntent->last_payment_error?->code,
                'failure_message' => $paymentIntent->last_payment_error?->message,
                'failed_at' => now(),
            ]);
        });
    }
}
