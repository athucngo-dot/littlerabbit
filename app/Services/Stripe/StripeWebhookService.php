<?php

namespace App\Services\Stripe;

use Stripe\Webhook;
use Illuminate\Support\Facades\DB;
use App\Models\WebhookEvent;

class StripeWebhookService
{
    /**
     * Constructor with dependency injection for StripePaymentService.
     */
    public function __construct( private readonly StripePaymentService $paymentService) 
    {}

    /**
     * Handle incoming Stripe webhook events.
     * This method ensures idempotency by checking if the event has already been processed before dispatching it to the appropriate handler based on the event type.
     */
    public function handle(string $payload, ?string $signature): void
    {
        // Construct the Stripe event using the payload and signature
        $event = $this->constructEvent($payload, $signature);

        // Idempotency at DB level
        if (WebhookEvent::where('stripe_event_id', $event->id)->exists()) {
            return;
        }

        // Store the event in the database to prevent duplicate processing
        WebhookEvent::create([
            'stripe_event_id' => $event->id,
            'type' => $event->type,
        ]);

        $this->dispatch($event);
    }

    /**
     * Construct a Stripe event from the payload and signature, verifying the signature using the webhook secret configured in the application settings.
     * This ensures that the event is legitimate and has not been tampered with.
     */
    private function constructEvent(string $payload, ?string $signature)
    {
        return Webhook::constructEvent(
            $payload,
            $signature,
            config('services.stripe.webhook_secret')
        );
    }

    /**
     * Dispatch the Stripe event to the appropriate handler based on the event type.
     * This method uses a match expression to route different event types to their corresponding handlers in the StripePaymentService,
     * allowing for clean and organized handling of various Stripe events such as payment successes and failures.
     */
    private function dispatch($event): void
    {
        match ($event->type) {
            'payment_intent.succeeded' =>
                $this->paymentService->handleSucceeded($event->data->object),

            'payment_intent.payment_failed' =>
                $this->paymentService->handleFailed($event->data->object),

            default => null,
        };
    }
}
