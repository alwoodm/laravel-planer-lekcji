<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejące przedmioty
        Subject::truncate();
        
        // Lista przedmiotów
        $subjects = [
            ['name' => 'Matematyka', 'code' => 'MAT'],
            ['name' => 'Język polski', 'code' => 'POL'],
            ['name' => 'Język angielski', 'code' => 'ANG'],
            ['name' => 'Historia', 'code' => 'HIST'],
            ['name' => 'Geografia', 'code' => 'GEO'],
            ['name' => 'Biologia', 'code' => 'BIO'],
            ['name' => 'Chemia', 'code' => 'CHEM'],
            ['name' => 'Fizyka', 'code' => 'FIZ'],
        ];

        // Tworzenie przedmiotów
        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
        
        $this->command->info('Utworzono 8 przedmiotów.');
    }
}
