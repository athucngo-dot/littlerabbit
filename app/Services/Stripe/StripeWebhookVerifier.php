<?php

namespace App\Services\Stripe;

use Stripe\Webhook;
use Stripe\Event;

class StripeWebhookVerifier
{
    public function constructEvent(string $payload, ?string $signature)
    {
        return Webhook::constructEvent(
            $payload,
            $signature,
            config('services.stripe.webhook_secret')
        );
    }
}