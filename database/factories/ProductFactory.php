<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Material;
use App\Models\Category;

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
            'price' => $this->faker->randomFloat(2, 5, 200),
            'stock' => $this->faker->numberBetween(0, 100),
            'nb_of_items' => $this->faker->numberBetween(1, 5), // Number of items in the product
            'img_url' => $this->faker->imageUrl(640, 480, 'fashion', true),
            'gender' => $this->faker->randomElement(['boy', 'girl', 'neutral']),
            'is_active' => $this->faker->boolean(90),
            'new_arrival' => $this->faker->boolean(30),
            'continue' => $this->faker->boolean(80),
            'color_id' => Color::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),
            'material_id' => Material::inRandomOrder()->value('id'),
            'category_id' => Category::inRandomOrder()->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }    
}
