<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LrUsersTableSeeder::class,
            ColorsTableSeeder::class,
            BrandsTableSeeder::class,
            CategoriesTableSeeder::class,
            MaterialsTableSeeder::class,
            SeasonsTableSeeder::class,
            DealsTableSeeder::class,
            SizesTableSeeder::class,
            ProductsTableSeeder::class,
            CustomersTableSeeder::class,
            ReviewsTableSeeder::class,
            // Add other seeders here as needed
        ]);
    }
}
