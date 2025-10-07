<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Material;
use App\Models\Category;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true), // e.g., "Comfortable Cotton Shirt"
            'description' => $this->faker->paragraph(), // English paragraph description
            'price' => $this->faker->randomFloat(2, 5, 30),
            'stock' => $this->faker->numberBetween(0, 100),
            'nb_of_items' => $this->faker->numberBetween(1, 5), // Number of items in the product
            'gender' => $this->faker->randomElement(['boy', 'girl', 'unisex']),
            'is_active' => $this->faker->boolean(90),
            'new_arrival' => $this->faker->boolean(30),
            'continue' => $this->faker->boolean(80),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'material_id' => Material::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }    

    public function configure()
    {
        /* After creating a product, create associated images */
        return $this->afterCreating(function ($product) {
            // Always create at least 1 image per product
            $imageCount = fake()->numberBetween(1, 3); // 1–3 images
            for ($i = 1; $i <= $imageCount; $i++) {
                \App\Models\Image::factory()
                    ->withProductName($product->name . '+' . $i) // add consecutive number
                    ->for($product) // sets product_id
                    ->create(
                        ['is_primary' => $i === 1] // first image is primary
                    );
            }
        });
    }
}
