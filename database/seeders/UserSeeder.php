<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $user = [
            'full_name' => "admin",
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        User::insert($user);
    }
}
