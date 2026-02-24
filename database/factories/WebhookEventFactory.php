<?php

namespace Database\Factories;

use App\Models\WebhookEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookEventFactory extends Factory
{
    protected $model = WebhookEvent::class;

    public function definition(): array
    {
        return [
            'stripe_event_id' => 'evt_' . $this->faker->unique()->bothify('????????????'), //evt_ followed by 12 random characters
            'type' => $this->faker->randomElement([
                'payment_intent.succeeded',
                'payment_intent.payment_failed',
                'charge.refunded',
                'invoice.payment_succeeded',
            ]),
        ];
    }

    public function paymentSucceeded(): static
    {
        return $this->state(fn () => [
            'type' => 'payment_intent.succeeded',
        ]);
    }

    public function paymentFailed(): static
    {
        return $this->state(fn () => [
            'type' => 'payment_intent.payment_failed',
        ]);
    }
}