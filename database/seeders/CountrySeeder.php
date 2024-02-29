<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['country_code' => '1', 'country' => 'United States'],
            ['country_code' => '1', 'country' => 'Canada'],
            ['country_code' => '44', 'country' => 'United Kingdom'],
            ['country_code' => '91', 'country' => 'India'],
            ['country_code' => '99', 'country' => 'Country Name'],
            // Add more countries as needed
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert($country);
        }
    }
}
