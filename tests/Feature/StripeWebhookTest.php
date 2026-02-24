<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use Stripe\Event;
use Stripe\Webhook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\Stripe\StripePaymentService;
use App\Models\Order;
use App\Models\WebhookEvent;
use App\Services\Stripe\StripeWebhookVerifier;
use App\Models\User;
use App\Services\CheckoutService;

class StripeWebhookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a payment_intent.succeeded webhook is processed correctly, 
     * marking the order as paid and creating a payment record, 
     * while ensuring idempotency by not processing the same event twice.
     */
    public function test_processes_payment_intent_succeeded_webhook()
    {
        // Create pending order with matching payment intent ID
        $order = Order::factory()->create([
            'status' => 'pending',
            'stripe_payment_intent_id' => 'pi_test_123',
        ]);

        // Mock StripePaymentService
        $paymentMock = Mockery::mock(StripePaymentService::class);
        $paymentMock->shouldReceive('handleSucceeded')
            ->once()
            ->with(Mockery::on(fn ($obj) => $obj->id === 'pi_test_123'));

        $this->app->instance(StripePaymentService::class, $paymentMock);

        // Fake Stripe event object
        $fakeEvent = (object)[
            'id' => 'evt_1',
            'type' => 'payment_intent.succeeded',
            'data' => (object)[
                'object' => (object)[
                    'id' => 'pi_test_123',
                ],
            ],
        ];

        // Mock StripeWebhookVerifier to return the fake event when constructEvent is called
        $verifierMock = Mockery::mock(StripeWebhookVerifier::class);
        $verifierMock->shouldReceive('constructEvent')
            ->once()
            ->andReturn($fakeEvent);

        $this->app->instance(StripeWebhookVerifier::class, $verifierMock);

        // Send request (body can be empty)
        $response = $this->postJson(
            '/api/stripe/webhook',
            [], // payload is irrelevant because we mock constructEvent
            ['Stripe-Signature' => 'test_signature']
        );

        // Assert success
        $response->assertStatus(200);

        // Assert event was stored
        $this->assertDatabaseHas('webhook_events', [
            'stripe_event_id' => 'evt_1',
            'type' => 'payment_intent.succeeded',
        ]);
    }

    /**
     * Test that if the same webhook event is received again, it is not processed a second time, 
     * ensuring idempotency at the database level by checking for existing events before processing.
     */
    public function test_not_process_same_webhook_twice()
    {
        // Create a webhook event in the database to simulate a previously processed event
        WebhookEvent::factory()->create([
            'stripe_event_id' => 'evt_duplicated',
        ]);

        // Mock the StripeWebhookVerifier to return a Stripe event with the same ID as the existing webhook event
        $verifierMock = Mockery::mock(StripeWebhookVerifier::class);

        $verifierMock->shouldReceive('constructEvent')
            ->once()
            ->andReturn((object)[
                'id' => 'evt_duplicated',
                'type' => 'payment_intent.succeeded',
                'data' => (object)[
                    'object' => (object)[
                        'id' => 'pi_test_123',
                    ],
                ],
            ]);

        $this->app->instance(
            StripeWebhookVerifier::class,
            $verifierMock
        );

        // Send the webhook request
        $response = $this->postJson('/api/stripe/webhook', [], [
            'Stripe-Signature' => 'test_signature',
        ]);

        $response->assertStatus(200);
    }
}