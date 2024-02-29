<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['city' => 'City 1','state_id'=>1],
            ['city' => 'City 2','state_id'=>1],
            // Add more cities as needed
        ];

        // Insert cities data into the database
        City::insert($cities);
    }
}
