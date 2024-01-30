<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;


class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create([
            'name' => 'Category Type 1',
           
            'created_by' => 1,
        ]);

        Category::create([
            'name' => 'Category Type 2',
           
            'created_by' => 1,
        ]);

        // Add more data as needed
    }
}