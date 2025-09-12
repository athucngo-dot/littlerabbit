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
            ['name' => 'Red', 'hex' => '#FF0000'],
            ['name' => 'Blue', 'hex' => '#0000FF'],
            ['name' => 'Yellow', 'hex' => '#FFFF00'],
            ['name' => 'Green', 'hex' => '#008000'],
            ['name' => 'Pink', 'hex' => '#FFC0CB'],
            ['name' => 'Purple', 'hex' => '#800080'],
            ['name' => 'Orange', 'hex' => '#FFA500'],
            ['name' => 'Brown', 'hex' => '#8B4513'],
            ['name' => 'White', 'hex' => '#FFFFFF'],
            ['name' => 'Black', 'hex' => '#000000'],
            ['name' => 'Grey', 'hex' => '#808080'],
            ['name' => 'Baby Pink', 'hex' => '#F4C2C2'],
            ['name' => 'Baby Blue', 'hex' => '#89CFF0'],
            ['name' => 'Mint Green', 'hex' => '#98FF98'],
            ['name' => 'Lavender', 'hex' => '#E6E6FA'],
            ['name' => 'Peach', 'hex' => '#FFE5B4'],
            ['name' => 'Sky Blue', 'hex' => '#87CEEB'],
            ['name' => 'Soft Yellow', 'hex' => '#FFFACD'],
            ['name' => 'Cream', 'hex' => '#FFFDD0'],
            ['name' => 'Lilac', 'hex' => '#C8A2C8'],
            ['name' => 'Turquoise', 'hex' => '#40E0D0'],
            ['name' => 'Hot Pink', 'hex' => '#FF69B4'],
            ['name' => 'Lime Green', 'hex' => '#32CD32'],
            ['name' => 'Bright Orange', 'hex' => '#FF5F1F'],
            ['name' => 'Electric Blue', 'hex' => '#7DF9FF'],
            ['name' => 'Sunshine Yellow', 'hex' => '#FFD300'],
            ['name' => 'Coral', 'hex' => '#FF7F50'],
            ['name' => 'Aqua', 'hex' => '#00FFFF'],
            ['name' => 'Fuchsia', 'hex' => '#FF00FF'],
            ['name' => 'Beige', 'hex' => '#F5F5DC'],
            ['name' => 'Olive', 'hex' => '#808000'],
            ['name' => 'Terracotta', 'hex' => '#E2725B'],
            ['name' => 'Mustard', 'hex' => '#FFDB58'],
            ['name' => 'Taupe', 'hex' => '#483C32'],
            ['name' => 'Charcoal', 'hex' => '#36454F'],
            ['name' => 'Sage Green', 'hex' => '#9CAF88'],
            ['name' => 'Dusty Rose', 'hex' => '#DCAE96'],
            ['name' => 'Dusty Blue', 'hex' => '#6699CC'],
            ['name' => 'Mauve', 'hex' => '#E0B0FF'],
            ['name' => 'Burnt Sienna', 'hex' => '#E97451'],
            ['name' => 'Clay', 'hex' => '#B66A50'],
            ['name' => 'Eucalyptus', 'hex' => '#5F8575'],
            ['name' => 'Blush', 'hex' => '#DE5D83'],
            ['name' => 'Slate', 'hex' => '#708090'],
            ['name' => 'Mocha', 'hex' => '#967969'],
            ['name' => 'Pistachio', 'hex' => '#93C572'],
            ['name' => 'Storm Blue', 'hex' => '#4B6189'],
        ];

        foreach ($colors as $color) {
            DB::table('colors')->insert([
                'name' => $color['name'],
                'hex' => $color['hex'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
