<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Deal;

class DealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deals = [
            ['name' => 'Spring Sale', 'percentage_off' => 20],
            ['name' => 'Summer Sale', 'percentage_off' => 15],
            ['name' => 'Fall Clearance', 'percentage_off' => 30],
            ['name' => 'Winter Discounts', 'percentage_off' => 25],
            ['name' => 'Holiday Specials', 'percentage_off' => 50],
            ['name' => 'Back to School', 'percentage_off' => 10],
            ['name' => 'Black Friday', 'percentage_off' => 40],
            ['name' => 'New Year Sale', 'percentage_off' => 20],
            ['name' => 'Valentine\'s Day', 'percentage_off' => 15],
            ['name' => 'Easter Deals', 'percentage_off' => 25],
            ['name' => 'Memorial Day', 'percentage_off' => 30],
            ['name' => 'Labor Day', 'percentage_off' => 20],
            ['name' => 'Thanksgiving', 'percentage_off' => 45],
            ['name' => 'Christmas Sale', 'percentage_off' => 50],
            ['name' => 'Anniversary Sale', 'percentage_off' => 30],
            ['name' => 'Clearance Sale', 'percentage_off' => 60],
            ['name' => 'Weekend Specials', 'percentage_off' => 10],
            ['name' => 'Flash Sale', 'percentage_off' => 70],
            ['name' => 'Loyalty Rewards', 'percentage_off' => 5],
            ['name' => 'Referral Discounts', 'percentage_off' => 10],
            ['name' => 'Bundle Offers', 'percentage_off' => 20],
            ['name' => 'Free Shipping', 'percentage_off' => 0],
            ['name' => 'Buy One Get One', 'percentage_off' => 50],
            ['name' => 'First Time Buyer', 'percentage_off' => 25],
            ['name' => 'Seasonal Clearance', 'percentage_off' => 30],
            ['name' => 'Limited Time Offer', 'percentage_off' => 40],
            ['name' => 'Exclusive Member Deals', 'percentage_off' => 15],
            ['name' => 'Early Bird Specials', 'percentage_off' => 20],
            ['name' => 'Last Minute Deals', 'percentage_off' => 30],
            ['name' => 'Social Media Promotions', 'percentage_off' => 15],
            ['name' => 'Email Subscriber Discounts', 'percentage_off' => 20],
            ['name' => 'App User Discounts', 'percentage_off' => 25],
            ['name' => 'Flash Clearance', 'percentage_off' => 50],
            ['name' => 'Seasonal Specials', 'percentage_off' => 30],
            ['name' => 'Holiday Bundles', 'percentage_off' => 40],
            ['name' => 'Gift Card Promotions', 'percentage_off' => 10],
            ['name' => 'Customer Appreciation', 'percentage_off' => 20],
            ['name' => 'Birthday Discounts', 'percentage_off' => 25],
            ['name' => 'Anniversary Specials', 'percentage_off' => 30],
            ['name' => 'Flash Promotions', 'percentage_off' => 50],
            ['name' => 'Limited Edition Offers', 'percentage_off' => 40],
            ['name' => 'Exclusive Sales', 'percentage_off' => 20],
            ['name' => 'Holiday Discounts', 'percentage_off' => 25],
            ['name' => 'Weekend Deals', 'percentage_off' => 15],
            ['name' => 'Weekly Specials', 'percentage_off' => 10],
            ['name' => 'Monthly Promotions', 'percentage_off' => 20],
            ['name' => 'Quarterly Sales', 'percentage_off' => 30],
            ['name' => 'Year-End Clearance', 'percentage_off' => 40],
            ['name' => 'Flash Sales', 'percentage_off' => 50],
            ['name' => 'Seasonal Discounts', 'percentage_off' => 20],
            ['name' => 'Holiday Offers', 'percentage_off' => 25],
            ['name' => 'Special Promotions', 'percentage_off' => 30],
            ['name' => 'Exclusive Discounts', 'percentage_off' => 15],
            ['name' => 'Limited Time Sales', 'percentage_off' => 10],
        ];

        foreach ($deals as $deal) {
            DB::table('deals')->insert([
                'name' => $deal['name'],
                'percentage_off' => $deal['percentage_off'],
                'start_date' => now()->subDays(rand(1, 30)), // Random start date within the last 30 days
                'end_date' => now()->addDays(rand(1, 30)), // Random end date within the next 30 days
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
