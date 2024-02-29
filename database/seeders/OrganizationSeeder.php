<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organization = [
            ['full_name' => 'Organization 1','user_type'=>"organization"],
            ['full_name' => 'Organization 2','user_type'=>"organization"],
            // Add more cities as needed
        ];
        User::insert($organization);
    }
}
