<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    protected $model = Image::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // fallback default text if no product assigned yet
        return [
            'url' => "https://placehold.co/600x600/FFF8E8/00cccc?text=fashion",
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * return the image url with a specific product name.
     */
    public function withProductName($productName)
    {
        $formattedName = str_replace(' ', '+', strtolower($productName));

        return $this->state(fn () => [
            'url' => "https://placehold.co/600x600/FFF8E8/00cccc?text={$formattedName}",
        ]);
    }
}
