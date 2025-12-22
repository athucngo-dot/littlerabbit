<?php
namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\Order;
use App\Models\Payment;
use App\Services\ProductService;
use App\Services\CartService;
use Stripe\Charge;
use Stripe\PaymentIntent as StripePaymentIntent;

class StripeService
{
    /**
     * Constructor to set the Stripe API key
     */
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Create a Payment Intent
     */
    public function createPaymentIntent(int $amount, string $orderId): PaymentIntent
    {
        // add metadata
        $customer = Auth::guard('customer')->user();
        $metadata = [
            'user_id' => $customer->id,
            'email'   => $customer->email,
            'order_id' => $orderId,
        ];
        
        return PaymentIntent::create([
            'amount' => intval($amount * 100), // in cents
            'currency' => 'cad',
            'metadata' => $metadata,
            'automatic_payment_methods' => ['enabled' => true],
        ]);
    }

    /**
     * Handle payment succeeded webhook event
     */
    public function handlePaymentSucceeded($paymentIntent): array
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order || $order->status === 'paid') {
            return ['status' => 'error', 'message' => 'Order not found or already paid'];
        }

        // Retrieve full PaymentIntent with expanded charges and payment method details
        $paymentIntentFull = StripePaymentIntent::retrieve(
            $paymentIntent->id,
            ['expand' => ['charges.data.payment_method']]
        );

        $chargeId = $paymentIntent->latest_charge;

        if (!$chargeId) {
            //Log::error('No latest_charge found for PaymentIntent: ' . $paymentIntent->id);
            return ['status' => 'error', 'message' => 'No latest_charge found for PaymentIntent'];
        }

        $charge = Charge::retrieve($chargeId);

        // get card details
        $cardDetails = $charge->payment_method_details->card ?? null;

        // Save payment info to DB
        Payment::create([
            'customer_id' => $order->customer_id,
            'order_id' => $order->id,
            'provider' => 'stripe',
            'payment_intent_id' => $paymentIntent->id,
            'payment_method_id' => $charge->payment_method,
            'charge_id' => $charge->id,
            'provider_customer_id' => $paymentIntentFull->customer,
            'card_brand' => $cardDetails->brand,
            'card_last_four' => $cardDetails->last4,
            'card_exp_month' => $cardDetails->exp_month,
            'card_exp_year' => $cardDetails->exp_year,
            'amount' => $paymentIntentFull->amount,
            'currency' => $paymentIntentFull->currency,
            'status' => 'succeeded',
            'paid_at' => now(),
            'receipt_url' => $charge->receipt_url,
        ]);

        // Update order status to paid
        $order->status = 'paid';
        $order->paid_at = now();
        $order->save();

        // reduce stock quantities 
        ProductService::reduceStockQuantities($order->id);

        return ['status' => 'success', 'message' => 'Payment processed and order updated'];
    }

    /**
     * Handle payment failed webhook event
     */
    public function handlePaymentFailed($paymentIntent): array
    {
        $order = Order::where('stripe_payment_intent_id', $paymentIntent->id)->first();

        if (!$order || $order->status === 'paid') {
            return ['status' => 'ignored', 'message' => 'Order not found or already paid'];
        }

        // Update order status to failed
        $order->status = 'failed';
        $order->failed_at = now();
        $order->save();

        // Save payment info to DB
        Payment::create([
            'customer_id' => $order->customer_id,
            'order_id' => $order->id,
            'provider' => 'stripe',
            'payment_intent_id' => $paymentIntent->id,
            'status' => 'failed',
            'amount' => $paymentIntent->amount,
            'currency' => $paymentIntent->currency,
            'failure_code' => $paymentIntent->last_payment_error->code,
            'failure_message' => $paymentIntent->last_payment_error->message,
            'failed_at' => now(),
        ]);

        return ['status' => 'failed', 'message' => $paymentIntent->last_payment_error->message];
    }
}
