<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SectionModule;

class SectionModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SectionModule::create([
            'section_id' => 1,
            'module_name' => 'Module 1',
            'created_by' => 1,
        ]);
        SectionModule::create([
            'section_id' => 2,
            'module_name' => 'Module 2',
            'created_by' => 1,
        ]);
    }
}