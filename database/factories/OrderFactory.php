<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_number' => 'LR-' . $this->faker->unique()->numberBetween(1000, 9999),
            'customer_id' => Customer::factory(),
            'status' => 'pending',
            'stripe_payment_intent_id' => null,
            'subtotal' => 100,
            'shipping' => 10,
            'total' => 110,
            'shipping_type' => 'standard',
            'paid_at' => null,
            'failed_at' => null,
            'options' => null,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn () => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn () => [
            'status' => 'pending',
        ]);
    }
}