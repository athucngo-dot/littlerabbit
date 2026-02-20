<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\Stripe\StripeWebhookService;

class StripeWebhookController extends Controller
{
    /**
     * Constructor with dependency injection for StripeWebhookService.
     */
    public function __construct(private readonly StripeWebhookService $webhookService)
    {}

    /**
     * Process the Stripe webhook event and return a JSON response.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        try {
            $this->webhookService->handle(
                payload: $request->getContent(),
                signature: $request->header('Stripe-Signature')
            );

            return response()->json(['status' => 'processed']);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'error' => 'Webhook processing failed'
            ], 400);
        }
    }
}

