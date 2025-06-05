<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentClassAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejące przypisania
        DB::table('student_class_assignments')->truncate();
        
        // Pobierz wszystkie klasy
        $classes = SchoolClass::all();
        
        // Pobierz wszystkich uczniów
        $students = User::where('role', 'student')->get();
        
        // Podziel uczniów równomiernie po 5 na klasę
        $studentIndex = 0;
        foreach ($classes as $class) {
            for ($i = 0; $i < 5; $i++) {
                if (isset($students[$studentIndex])) {
                    DB::table('student_class_assignments')->insert([
                        'user_id' => $students[$studentIndex]->id,
                        'class_id' => $class->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $studentIndex++;
                }
            }
        }
        
        $this->command->info('Przypisano 30 uczniów do 6 klas (po 5 uczniów w każdej klasie).');
    }
}
