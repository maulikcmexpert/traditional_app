<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lifestyle;
class LifestyleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lifestyles = [
            ['life_style' => 'Active'],
            ['life_style' => 'Sedentary'],
            ['life_style' => 'Outdoor enthusiast'],
            ['life_style' => 'Gamer'],
            ['life_style' => 'Health conscious'],
            // Add more lifestyles as needed
        ];
        Lifestyle::insert($lifestyles);
    }
}
