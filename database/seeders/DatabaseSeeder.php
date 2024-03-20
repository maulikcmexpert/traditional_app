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

        // DB::table('users')->insert([
        //     'full_name' => "admin",
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('admin@123'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now()
        // ]);

        $this->call([

            LifestyleSeeder::class,
            InterestAndHobbySeeder::class,
            ZodiacSeeder::class,
            OrganizationSeeder::class,
            SizeOfOrganizationSeeder::class
            // Other seeders if you have
        ]);
    }
}
