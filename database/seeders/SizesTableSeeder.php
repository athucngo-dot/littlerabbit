<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Size;

class SizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kidsSizes = [
            'baby' => [
                'NB',// Newborn
                '3M',// 0-3 Months
                '6M',// 3-6 Months
                '9M',// 6-9 Months
                '12M',// 9-12 Months
                '18M',// 12-18 Months
                '24M',// 18-24 Months
            ],
            'toddler' => [
                '2T',
                '3T',
                '4T',
                '5T',
            ],
            'kid' => [
                '4',
                '5',
                '6',
                '7',
                '8',
                '10',
                '12',
                '14',
                '16',
                '18',
                '20',
            ],
        ];

        foreach ($kidsSizes as $kidsSizesKey => $sizes) {
            foreach ($sizes as $size) {
                DB::table('sizes')->insert([
                    'child_cat' => $kidsSizesKey,
                    'size' => $size,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
