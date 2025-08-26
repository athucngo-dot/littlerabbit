<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Season;

class MaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            'Cotton',
            'Organic Cotton',
            'Bamboo',
            'Linen',
            'Jersey Cotton',
            'Fleece',
            'French Terry',
            'Terry Cloth',
            'Muslin',
            'Denim',
            'Corduroy',
            'Velour',
            'Wool',
            'Merino Wool',
            'Cashmere',
            'Polyester',
            'Recycled Polyester',
            'Nylon',
            'Spandex',
            'Elastane',
            'Rayon',
            'Modal',
            'Tencel',
            'Viscose',
            'Acrylic',
            'Silk',
            'Leather (Faux)',
            'PU Leather',
            'Canvas',
            'Chambray',
            'Seersucker',
            'Mesh',
            'Quilted Cotton',
        ];

        foreach ($materials as $material) {
            DB::table('materials')->insert([
                'name' => $material,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
