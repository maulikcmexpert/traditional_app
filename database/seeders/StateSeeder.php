<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
use Carbon\Carbon;
class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $states = [
            ['state' => 'State 1','country_code'=>'1' ,'code'=>'01','created_at' => $now, 'updated_at' => $now],
            ['state' => 'State 2', 'country_code'=>'1','code'=>'01','created_at' => $now, 'updated_at' => $now],
            // Add more states as needed
        ];

        // Insert states data into the database
        State::insert($states);
    }
}
