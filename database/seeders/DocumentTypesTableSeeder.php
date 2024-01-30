<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypesTableSeeder extends Seeder
{
    public function run()
    {
        DocumentType::create([
            'name' => 'Document Type 1',
            'created_by' => 1,
        ]);

        DocumentType::create([
            'name' => 'Document Type 2',
            'created_by' => 1,
        ]);

        // Add more data as needed
    }
}