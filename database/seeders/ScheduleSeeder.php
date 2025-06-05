<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\TimeSlot;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejące plany lekcji
        Schedule::truncate();
        
        // Pobierz dane do planów
        $classes = SchoolClass::all();
        $subjects = Subject::all();
        $teachers = User::where('role', 'teacher')->get();
        $timeSlots = TimeSlot::all();
        
        // Dni tygodnia
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        
        // Przykładowe numery sal
        $rooms = ['A101', 'A102', 'A103', 'B201', 'B202', 'B203', 'C301', 'C302', 'C303'];
        
        // Dla każdej klasy tworzymy 2-3 lekcje dziennie
        foreach ($classes as $class) {
            foreach ($weekDays as $day) {
                // 2-3 lekcje dziennie
                $lessonsPerDay = rand(2, 3);
                
                // Wybieramy losowe godziny lekcyjne dla danego dnia (bez powtórzeń)
                $dayTimeSlots = $timeSlots->random($lessonsPerDay);
                
                foreach ($dayTimeSlots as $timeSlot) {
                    // Wybieramy losowy przedmiot
                    $subject = $subjects->random();
                    
                    // Wybieramy losowego nauczyciela, który nie ma konfliktu w planie
                    $availableTeacher = null;
                    $shuffledTeachers = $teachers->shuffle();
                    
                    foreach ($shuffledTeachers as $teacher) {
                        if (!Schedule::hasConflict($teacher->id, $timeSlot->id, $day)) {
                            $availableTeacher = $teacher;
                            break;
                        }
                    }
                    
                    // Jeżeli znaleziono dostępnego nauczyciela
                    if ($availableTeacher) {
                        // Losowa sala
                        $room = $rooms[array_rand($rooms)];
                        
                        // Tworzenie lekcji w planie
                        Schedule::create([
                            'class_id' => $class->id,
                            'subject_id' => $subject->id,
                            'user_id' => $availableTeacher->id,
                            'time_slot_id' => $timeSlot->id,
                            'day_of_week' => $day,
                            'room' => $room,
                        ]);
                    }
                }
            }
        }
        
        // Zliczanie utworzonych lekcji
        $lessonsCount = Schedule::count();
        $this->command->info('Utworzono ' . $lessonsCount . ' lekcji w planach.');
    }
}
