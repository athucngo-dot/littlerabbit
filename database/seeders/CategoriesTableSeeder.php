<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Tops',
            'T-Shirts',
            'Shirts',
            'Sweaters',
            'Hoodies',
            'Jackets',
            'Coats',
            'Dresses',
            'Skirts',
            'Pants',
            'Jeans',
            'Shorts',
            'Leggings',
            'Overalls',
            'Rompers',
            'Sleepwear',
            'Pyjamas',
            'Undergarments',
            'Socks',
            'Swimwear',
            'Rainwear',
            'Shoes',
            'Boots',
            'Sandals',
            'Sneakers',
            'Hats',
            'Caps',
            'Beanies',
            'Mittens',
            'Gloves',
            'Scarves',
            'School Uniforms',
            'Party Wear',
            'Activewear',
            'Sportswear',
            'Costumes',
            'Bibs',
            'Onesies',
            'Bodysuits',
            'Thermals',
            'Outerwear',
            'Accessories',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
