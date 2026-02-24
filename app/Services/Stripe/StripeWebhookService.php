<?php

namespace App\Services\Stripe;

use Stripe\Webhook;
use Illuminate\Support\Facades\DB;
use App\Models\WebhookEvent;
use App\Services\Stripe\StripeWebhookVerifier;

class StripeWebhookService
{
    /**
     * Constructor with dependency injection for StripeWebhookVerifier and StripePaymentService.
     * This allows for better separation of concerns and easier testing by injecting the necessary services for verifying webhooks and handling payment-related logic.
     */
    public function __construct(
        protected StripeWebhookVerifier $verifier,
        protected StripePaymentService $paymentService
    ) {}

    /**
     * Handle incoming Stripe webhook events.
     * This method ensures idempotency by checking if the event has already been processed before dispatching it to the appropriate handler based on the event type.
     */
    public function handle(string $payload, ?string $signature): void
    {
        // Verify the webhook signature and construct the Stripe event object
        $event = $this->verifier->constructEvent($payload, $signature);
        
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
