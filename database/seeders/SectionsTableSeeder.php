<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Section::create([
            'user_id' => 1,
            'title' => 'Section 1',
            'status' => 'approved',
            'approve_at' => now(),
            'created_by' => 'Seeder',
        ]);
        Section::create([
            'user_id' => 2,
            'title' => 'Section 2',
            'status' => 'not_approved',
            'approve_at' => null,
            'created_by' => 'Seeder',
            // Add more sections as needed
        ]);
    }
}