<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Color;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            'Red',
            'Blue',
            'Yellow',
            'Green',
            'Pink',
            'Purple',
            'Orange',
            'Brown',
            'White',
            'Black',
            'Grey',
            'Baby Pink',
            'Baby Blue',
            'Mint Green',
            'Lavender',
            'Peach',
            'Sky Blue',
            'Soft Yellow',
            'Cream',
            'Lilac',
            'Turquoise',
            'Hot Pink',
            'Lime Green',
            'Bright Orange',
            'Electric Blue',
            'Sunshine Yellow',
            'Coral',
            'Aqua',
            'Fuchsia',
            'Beige',
            'Olive',
            'Terracotta',
            'Mustard',
            'Taupe',
            'Charcoal',
            'Sage Green',
            'Dusty Rose',
            'Dusty Blue',
            'Mauve',
            'Burnt Sienna',
            'Clay',
            'Eucalyptus',
            'Blush',
            'Slate',
            'Mocha',
            'Pistachio',
            'Storm Blue',
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'name' => $color,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
