<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = \App\Models\Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rv_quality = $this->faker->numberBetween(0, 5);
        $rv_comfort = $this->faker->numberBetween(0, 5);
        $rv_size = $this->faker->numberBetween(0, 5);
        $rv_delivery = $this->faker->numberBetween(0, 5);
        // round up the average rating
        $rv_rate = round(($rv_quality + $rv_comfort + $rv_size + $rv_delivery) / 4);

        // Return the review data
        return [
            'product_id' => Product::inRandomOrder()->value('id'),
            'customer_id' => Customer::inRandomOrder()->value('id'),
            'rv_rate' => $rv_rate,
            'rv_comment' => $this->faker->paragraph(), // English paragraph description
            'rv_quality' => $rv_quality,
            'rv_comfort' => $rv_comfort,
            'rv_size' => $rv_size,
            'rv_delivery' => $rv_delivery,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
