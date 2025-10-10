<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Material;
use App\Models\Category;
use App\Models\Deal;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_new_arrival_products()
    {
        // Create a few products
        $threeNewProducts = [
                [
                    'name' => 'Comfy Denim Jeans',
                    'slug' => 'comfy-denim-jeans',
                    'is_active' => true,
                    'new_arrival' => true
                ],
                [
                    'name' => 'Warm Wool Sweater',
                    'slug' => 'warm-wool-sweater',
                    'is_active' => true,
                    'new_arrival' => true
                ],
                [
                    'name' => 'Light Cotton Dress',
                    'slug' => 'light-cotton-dress',
                    'is_active' => true,
                    'new_arrival' => false
                ]
        ];

        $product = Product::factory()
            ->count(3)
            ->state(new Sequence(...$threeNewProducts))
            ->create();

        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Only 2 products are new arrivals
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);
    }

    public function test_get_new_arrival_with_inactive_products()
    {
        // Create a few products
        $threeNewProducts = [
                [
                    'name' => 'Comfy Denim Jeans',
                    'slug' => 'comfy-denim-jeans',
                    'is_active' => true,
                    'new_arrival' => true
                ],
                [
                    'name' => 'Warm Wool Sweater',
                    'slug' => 'warm-wool-sweater',
                    'is_active' => false,
                    'new_arrival' => true
                ],
                [
                    'name' => 'Light Cotton Dress',
                    'slug' => 'light-cotton-dress',
                    'is_active' => true,
                    'new_arrival' => false
                ]
        ];

        $product = Product::factory()
            ->count(3)
            ->state(new Sequence(...$threeNewProducts))
            ->create();

        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 2 products are new arrivals
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
    }
}