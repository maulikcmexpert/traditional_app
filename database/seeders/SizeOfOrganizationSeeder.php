<?php

namespace Database\Seeders;

use App\Models\SizeOfOrganization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeOfOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sizes = [
            ['size_range'=>'0-50'],
            ['size_range'=>'50-100'],
            ['size_range'=>'100-150'],
        ];
        SizeOfOrganization::insert($sizes);
    }
}
