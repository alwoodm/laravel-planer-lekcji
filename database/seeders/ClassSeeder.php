<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejące klasy
        SchoolClass::truncate();
        
        // Lista klas
        $classes = [
            ['name' => '1A', 'year_level' => 1, 'academic_year' => '2024/2025'],
            ['name' => '1B', 'year_level' => 1, 'academic_year' => '2024/2025'],
            ['name' => '2A', 'year_level' => 2, 'academic_year' => '2024/2025'],
            ['name' => '2B', 'year_level' => 2, 'academic_year' => '2024/2025'],
            ['name' => '3A', 'year_level' => 3, 'academic_year' => '2024/2025'],
            ['name' => '3B', 'year_level' => 3, 'academic_year' => '2024/2025'],
        ];

        // Tworzenie klas
        foreach ($classes as $class) {
            SchoolClass::create($class);
        }
        
        $this->command->info('Utworzono 6 klas szkolnych.');
    }
}
