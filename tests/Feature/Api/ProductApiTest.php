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
        // Seed products
        $this->createNewProducts();

        // Change one product to new_arrival = false
        Product::where('slug', 'light-cotton-dress')->update(['new_arrival' => false]);

        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Only 2 products are new arrivals
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);
        $response->assertJsonMissing(['slug' => 'light-cotton-dress']); 
    }

    public function test_get_new_arrival_with_inactive_products()
    {
        // Seed products
        $this->createNewProducts();

        // change one product to inactive
        Product::where('slug', 'warm-wool-sweater')->update(['is_active' => false]);
        
        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Only 2 products are new arrivals
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
    }

    public function test_get_new_arrival_products_filter_by_brand_material_category()
    {
        $this->createNewBrands();
        $this->createNewMaterials();
        $this->createNewCategories();

        // Seed products
        $this->createNewProducts();

        // Assign brands, materials, categories
        Product::where('slug', 'comfy-denim-jeans')->update(['brand_id' => 1, 'material_id' => 1, 'category_id' => 1]);
        Product::where('slug', 'warm-wool-sweater')->update(['brand_id' => 2, 'material_id' => 2, 'category_id' => 2]);
        Product::where('slug', 'light-cotton-dress')->update(['brand_id' => 3, 'material_id' =>3, 'category_id' => 3]);

        // Test filter by brand_id
        $response = $this->getJson('/api/products/new-arrivals?brand_id=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are new arrivals
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);

        // Test filter by material_id
        $response = $this->getJson('/api/products/new-arrivals?material_id=2');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are new arrivals
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);

        // Test filter by category_id
        $response = $this->getJson('/api/products/new-arrivals?category_id=3');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are new arrivals
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
    }

    /** Helper to create new products */
    private function createNewProducts(array $products = []): void
    {
        if (empty($products)) {
            $products = [
                [
                    'id' => 1,
                    'name' => 'Comfy Denim Jeans',
                    'slug' => 'comfy-denim-jeans',
                    'is_active' => true,
                    'new_arrival' => true
                ],
                [
                    'id' => 2,
                    'name' => 'Warm Wool Sweater',
                    'slug' => 'warm-wool-sweater',
                    'is_active' => true,
                    'new_arrival' => true
                ],
                [
                    'id' => 3,
                    'name' => 'Light Cotton Dress',
                    'slug' => 'light-cotton-dress',
                    'is_active' => true,
                    'new_arrival' => true
                ]
            ];
        }

        $this->createNew(Product::class, $products);
    }

    /** Helper to create new brands */
    private function createNewBrands(array $brands = []): void
    {
        if (empty($brands)) {
            $brands = [
                ['id' => 1, 'name' => 'Baby Gap'],
                ['id' => 2, 'name' => 'H&M Kids'],
                ['id' => 3, 'name' => 'Janie and Jack']
            ];
        }

        $this->createNew(Brand::class, $brands);
    }

    /** Helper to create new materials */
    private function createNewMaterials(array $materials = []): void
    {
        if (empty($materials)) {
            $materials = [
                ['id' => 1, 'name' => 'Cotton'],
                ['id' => 2, 'name' => 'Wool'],
                ['id' => 3, 'name' => 'Cashmere']
            ];
        }

        $this->createNew(Material::class, $materials);
    }

    /** Helper to create new categories */
    private function createNewCategories(array $categories = []): void
    {
        if (empty($categories)) {
            $categories = [
                ['id' => 1, 'name' => 'T-Shirts'],
                ['id' => 2, 'name' => 'Jackets'],
                ['id' => 3, 'name' => 'Jeans']
            ];
        }

        $this->createNew(Category::class, $categories);
    }
}