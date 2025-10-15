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
use App\Models\Size;
use App\Models\Color;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching new arrival products
     */
    public function test_get_new_arrival_products()
    {
        // Seed products
        $this->createNewProducts();

        // Change one product to new_arrival = false
        Product::where('slug', 'light-cotton-dress')->update(['new_arrival' => false]);

        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Only 2 products are fetched
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);
        $response->assertJsonMissing(['slug' => 'light-cotton-dress']); 
    }

    /**
     * Test fetching new arrival products excluding inactive products
     */
    public function test_get_new_arrival_with_inactive_products()
    {
        // Seed products
        $this->createNewProducts();

        // change one product to inactive
        Product::where('slug', 'warm-wool-sweater')->update(['is_active' => false]);
        
        $response = $this->getJson('/api/products/new-arrivals');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // Only 2 products are fetched
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
    }

    /**
     * Test fetching new arrival products filtered by brand_id
     */
    public function test_get_new_arrival_products_filter_by_brand()
    {
        // Seed brands
        $this->createNewBrands();

        // Seed products
        $this->createNewProducts();

        // Assign brands
        Product::where('slug', 'comfy-denim-jeans')->update(['brand_id' => 1]);
        Product::where('slug', 'warm-wool-sweater')->update(['brand_id' => 1]);

        // Test filter by brand_id
        $response = $this->getJson('/api/products/new-arrivals?brand_id=1');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // 2 products are fetched
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);
        $response->assertJsonMissing(['slug' => 'light-cotton-dress']);
    }

    /**
     * Test fetching new arrival products filtered by material_id
     */
    public function test_get_new_arrival_products_filter_by_material()
    {
        // Seed materials
        $this->createNewMaterials();        

        // Seed products
        $this->createNewProducts();

        // Assign materials
        Product::where('slug', 'light-cotton-dress')->update(['material_id' => 2]);

        // Test filter by material_id
        $response = $this->getJson('/api/products/new-arrivals?material_id=2');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are fetched
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
    }

    /**
     * Test fetching new arrival products filtered by category_id
     */
    public function test_get_new_arrival_products_filter_by_category()
    {
        // Seed categories
        $this->createNewCategories();

        // Seed products
        $this->createNewProducts();

        // Assign categories
        Product::where('slug', 'light-cotton-dress')->update(['category_id' => 3]);

        // Test filter by category_id
        $response = $this->getJson('/api/products/new-arrivals?category_id=3');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are fetched
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
    }

    /**
     * Test fetching new arrival products filtered by gender
     */
    public function test_get_new_arrival_products_filter_by_gender()
    {
        // Seed products
        $this->createNewProducts();

        // Assign brands, materials, categories
        Product::where('slug', 'comfy-denim-jeans')->update(['gender' => 'girl']);
        Product::where('slug', 'light-cotton-dress')->update(['gender' => 'girl']);

        // Test filter by gender = girl
        $response = $this->getJson('/api/products/new-arrivals?gender=girl');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // 2 products are fetched
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
    }

    /**
     * Test fetching new arrival products filtered by size_id
     */
    public function test_get_new_arrival_products_filter_by_size()
    {
        // Seed sizes
        $this->createNewSizes();

        // Seed products
        $this->createNewProducts();

        // Assign sizes
        $sizeIds = Size::where('id', 2)->pluck('id')->toArray();
        $product = Product::where('slug', 'warm-wool-sweater')->first();
        $product->sizes()->attach($sizeIds);

        // Test filter by size_id = 2
        $response = $this->getJson('/api/products/new-arrivals?size_id=2');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are fetched
        $response->assertJsonFragment(['slug' => 'warm-wool-sweater']);
        $response->assertJsonMissing(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'comfy-denim-jeans']);
    }

    /**
     * Test fetching new arrival products filtered by color_id
     */
    public function test_get_new_arrival_products_filter_by_color()
    {
        // Seed sizes
        $this->createNewColors();

        // Seed products
        $this->createNewProducts();

        // Assign sizes
        $colorIds = Color::where('id', 1)->pluck('id')->toArray();
        $product = Product::where('slug', 'light-cotton-dress')->first();
        $product->colors()->attach($colorIds);

        // Test filter by color_id = 1
        $response = $this->getJson('/api/products/new-arrivals?color_id=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // Only 1 products are fetched
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);
        $response->assertJsonMissing(['slug' => 'comfy-denim-jeans']);
    }

    /**
     * Test fetching new arrival products filtered by discount
     */
    public function test_get_new_arrival_products_filter_by_discount()
    {
        // Seed deals
        $this->createNewDeals();

        // Seed products
        $this->createNewProducts();

        // Assign deals
        $dealIds = Deal::where('percentage_off', 25)
            ->orWhere('percentage_off', 30)
            ->pluck('id')->toArray();
        
        $product = Product::where('slug', 'light-cotton-dress')->first();
        $product->deals()->attach($dealIds);

        $dealIds2 = Deal::where('percentage_off', 10)->pluck('id')->toArray();
        $product2 = Product::where('slug', 'comfy-denim-jeans')->first();
        $product2->deals()->attach($dealIds2);

        // Test filter by discount <= 25
        $response = $this->getJson('/api/products/new-arrivals?discount=25');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data'); // 2 products are fetched
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonFragment(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);

        // Test filter by discount >= 25 and <= 50
        $response = $this->getJson('/api/products/new-arrivals?discount=25-50');
        
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data'); // 1 products are fetched
        $response->assertJsonFragment(['slug' => 'light-cotton-dress']);
        $response->assertJsonMissing(['slug' => 'comfy-denim-jeans']);
        $response->assertJsonMissing(['slug' => 'warm-wool-sweater']);

        // Test filter by discount >= 50 and <= 75
        $response = $this->getJson('/api/products/new-arrivals?discount=50-75');
        
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data'); // 0 products are fetched
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

    /** Helper to create new sizes */
    private function createNewSizes(array $sizes = []): void
    {
        if (empty($sizes)) {
            $sizes = [
                ['id' => 1, 'child_cat' => 'baby', 'size' => 'NB'],
                ['id' => 2, 'child_cat' => 'baby', 'size' => '3M'],
                ['id' => 3, 'child_cat' => 'baby', 'size' => '6M'],
                ['id' => 4, 'child_cat' => 'toddler', 'size' => '2T'],
                ['id' => 5, 'child_cat' => 'toddler', 'size' => '3T'],
                ['id' => 6, 'child_cat' => 'toddler', 'size' => '4T'],
                ['id' => 7, 'child_cat' => 'older', 'size' => '4'],
                ['id' => 8, 'child_cat' => 'older', 'size' => '5'],
                ['id' => 9, 'child_cat' => 'older', 'size' => '6']
            ];
        }

        $this->createNew(Size::class, $sizes);
    }

    /** Helper to create new colors */
    private function createNewColors(array $colors = []): void
    {
        if (empty($colors)) {
            $colors = [
                ['id' => 1, 'name' => 'Red'],
                ['id' => 2, 'name' => 'Blue'],
                ['id' => 3, 'name' => 'Yellow']
            ];
        }

        $this->createNew(Color::class, $colors);
    }

    /** Helper to create new deals */
    private function createNewDeals(array $deals = []): void
    {
        if (empty($deals)) {
            $deals = [
                ['id' => 1, 'name' => 'Flash Sale', 'percentage_off' => 10, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ],
                ['id' => 2, 'name' => 'Holiday Sale', 'percentage_off' => 25, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ],
                ['id' => 3, 'name' => 'Clearance Sale', 'percentage_off' => 30, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ],
                ['id' => 4, 'name' => 'Black Friday Sale', 'percentage_off' => 35, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ],
                ['id' => 5, 'name' => 'Cyber Monday Sale', 'percentage_off' => 50, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ],
                ['id' => 6, 'name' => 'Year End Sale', 'percentage_off' => 55, 'start_date' => now()->subDays(), 'end_date' => now()->addDays(7) ]
            ];
        }

        $this->createNew(Deal::class, $deals);
    }
}