<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = [
            ['name' => '1st Year'],
            ['name' => '2nd Year'],
            ['name' => '3rd Year'],
            ['name' => '4th Year'],
        ];

        foreach ($academicYears as $year) {
            AcademicYear::firstOrCreate($year);
        }
    }
}
