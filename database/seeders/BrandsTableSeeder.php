<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            "Carter\'s",
            "OshKosh B\'gosh",
            "Baby Gap",
            "Old Navy Kids",
            "H&M Kids",
            "Zara Kids",
            "The Children\'s Place",
            "Janie and Jack",
            "Gymboree",
            "Mini Boden",
            "Nike Kids",
            "Adidas Kids",
            "Under Armour Kids",
            "Cat & Jack",
            "Tea Collection",
            "Primary",
            "Burt\'s Bees Baby",
            "Kyte Baby",
            "Little Me",
            "Hanna Andersson",
            "Monica + Andy",
            "Baby Mori",
            "Maisonette",
            "Pehr",
            "Loulou Lollipop",
            "Touched by Nature",
            "Little Planet by Carter\'s",
            "PatPat",
            "Bobo Choses",
            "Rylee + Cru",
            "Souris Mini",
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
