<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()
            ->count(50) // Adjust the number of customers to create as needed
            ->create();

        // seeding carts for random customers
        Customer::all()->each(function ($customer) {
            $take = rand(1, 100) <= 70 ? 0 : rand(1, 5); // 70% chance of having no products in cart
            if ($take === 0) {
                return; // Skip attaching products if take is 0
            }   
            $products = \App\Models\Product::inRandomOrder()->take($take)->pluck('id');
            $customer->carts()->attach($products);
        });
    }
}
