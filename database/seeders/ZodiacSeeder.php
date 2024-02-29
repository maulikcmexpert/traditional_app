<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ZodiacSign;
class ZodiacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zodiacs = [
            ['zodiac_sign' => 'Aries'],
            ['zodiac_sign' => 'Taurus'],
            ['zodiac_sign' => 'Gemini'],
            ['zodiac_sign' => 'Cancer'],
            ['zodiac_sign' => 'Leo'],
            ['zodiac_sign' => 'Virgo'],
            ['zodiac_sign' => 'Libra'],
            ['zodiac_sign' => 'Scorpio'],
            ['zodiac_sign' => 'Sagittarius'],
            ['zodiac_sign' => 'Capricorn'],
            ['zodiac_sign' => 'Aquarius'],
            ['zodiac_sign' => 'Pisces'],
        ];

        // Insert the zodiac data into the database
        ZodiacSign::insert($zodiacs);
    }
}
