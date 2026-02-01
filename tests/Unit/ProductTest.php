<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Image;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new product with expected fillable fields.
     */
    public function test_create_new_product_with_expected_fields(): void
    {
        // setup data
        $data = [
            'name' => 'Colorful t-shirt',
            'slug' => 'colorful-t-shirt',
            'description' => 'Soft and cute',
            'features' => 'Cotton, handmade',
            'price' => 29.99,
            'nb_of_items' => 1,
            'stock' => 100,
            'gender' => 'unisex',
            'is_active' => true,
            'new_arrival' => true,
            'homepage_promo' => false,
            'continue' => true
        ];

        $product = new Product($data);

        foreach ($data as $key => $value) {
            $this->assertEquals($value, $product->{$key});
        }
    }

    /**
     * Test that unfillable attributes are not set during mass assignment.
     */
    public function test_not_allow_create_new_product_with_unfillable_attributes()
    {
        // setup data with unfillable attribute 'id'
        $product = new Product([
            'name' => 'Winter Jacket',
            'id' => 999,
        ]);

        $this->assertNull($product->id);
    }

    /**
     * Test getting product thumbnail URL when no images are associated.
     */
    public function test_get_product_thumbnail_with_no_images()
    {
        // seeds to create a product
        $this->createNewProducts();
        
        $product = Product::where('slug', 'colorful-t-shirt')->first();
        $this->assertEquals(config('site.default_product_image'), $product->thumbnail());
    }

    /**
     * Test getting product thumbnail URL when no primary images are associated.
     */
    public function test_get_product_thumbnail_without_primary_images()
    {
        // seeds to create a product
        $this->createNewProducts();

        $product = Product::where('slug', 'colorful-t-shirt')->first();

        // create secondary image only
        $imageSecondary = Image::create([
            'product_id' => $product->id,
            'url' => 'secondaryImg.jpg',
            'is_primary' => false,
        ]);

        $this->assertEquals(config('site.default_product_image'), $product->thumbnail());
    }

    /**
     * Test getting product thumbnail URL when a primary image is associated.
     */
    public function test_get_product_thumbnail_with_primary_image()
    {
        // seeds to create a product
        $this->createNewProducts();

        $product = Product::where('slug', 'colorful-t-shirt')->first();

        // create primary and secondary images
        $imagePrimary = Image::create([
            'product_id' => $product->id,
            'url' => 'primaryImg.jpg',
            'is_primary' => true,
        ]);

        $imageSecondary = Image::create([
            'product_id' => $product->id,
            'url' => 'secondaryImg.jpg',
            'is_primary' => false,
        ]);

        $this->assertEquals(Storage::url($imagePrimary->url), $product->thumbnail());
    }

    /** Helper to create new products */
    private function createNewProducts(array $products = []): void
    {
        if (empty($products)) {
            $products = [
                [
                    'name' => 'Colorful t-shirt',
                    'slug' => 'colorful-t-shirt',
                    'description' => 'Soft and cute',
                    'features' => 'Cotton, handmade',
                    'price' => 29.99,
                    'nb_of_items' => 1,
                    'stock' => 100,
                    'gender' => 'unisex',
                    'is_active' => true,
                    'new_arrival' => true,
                    'homepage_promo' => false,
                    'continue' => true
                ]
            ];
        }

        $this->createNew(Product::class, $products);
    }
}
