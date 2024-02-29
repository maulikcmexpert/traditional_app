<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InterestAndHobby;
class InterestAndHobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interestsAndHobbies = [
            ['interest_and_hobby' => 'Reading'],
            ['interest_and_hobby' => 'Traveling'],
            ['interest_and_hobby' => 'Cooking'],
            ['interest_and_hobby' => 'Hiking'],
            ['interest_and_hobby' => 'Photography'],
            // Add more interests and hobbies as needed
        ];
        InterestAndHobby::insert($interestsAndHobbies);
    }
}
