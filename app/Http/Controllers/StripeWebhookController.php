<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Webhook;

use App\Models\Order;
use App\Services\ProductService;
use App\Services\CartService;
use App\Models\WebhookEvent;
use App\Services\StripeService;

class StripeWebhookController extends Controller
{
    /**
     * Handle Webhook from Stripe
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // Idempotency check
        if (WebhookEvent::where('stripe_event_id', $event->id)->exists()) {
            return response()->json(['status' => 'already_processed'], 200);
        }

        // Store event ID in DB
        WebhookEvent::create([
            'stripe_event_id' => $event->id,
            'type' => $event->type,
        ]);

        $stripe = new StripeService();

        // handle different event types
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $result = $stripe->handlePaymentSucceeded($event->data->object);
                if ($result['status'] === 'ignored') {
                    return response()->json(['ignored' => true]);
                }
                
                return response()->json(['status' => 'success']);

            case 'payment_intent.payment_failed':
                $result = $stripe->handlePaymentFailed($event->data->object);
                return response()->json(['status' => $result['status']]);
                
            default:
                return response()->json(['status' => 'ignored'], 200);
        }
    }
}
