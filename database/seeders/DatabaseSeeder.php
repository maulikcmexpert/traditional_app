<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CitySeeder::class,
            StateSeeder::class,
            CountrySeeder::class, // Include the CountrySeeder here
            // Add more seeders here if needed
        ]);

        // DB::table('users')->insert([
        //     'username' => "admin",
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin@123'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        // ]);
    }
}
