<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subcategory;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Subcategory::create([
            'name' => 'Subcategory Type 4',
            'category_id' => '2',
            'created_by' => 1,
        ]);

        Subcategory::create([
            'name' => 'Subcategory Type 5',
            'category_id' => '2',
            'created_by' => 1,
        ]);

        // Add more data as needed
    }
}