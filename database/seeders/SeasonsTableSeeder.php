<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Season;

class SeasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasons = [
            'Spring',
            'Summer',
            'Fall',
            'Winter',
        ];

        foreach ($seasons as $season) {
            DB::table('seasons')->insert([
                'name' => $season,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
