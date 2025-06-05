<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Seeder;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejące godziny lekcyjne
        TimeSlot::truncate();
        
        // Lista godzin lekcyjnych
        $timeSlots = [
            ['start_time' => '08:00', 'end_time' => '08:45', 'period_number' => 1],
            ['start_time' => '08:55', 'end_time' => '09:40', 'period_number' => 2],
            ['start_time' => '09:50', 'end_time' => '10:35', 'period_number' => 3],
            ['start_time' => '10:45', 'end_time' => '11:30', 'period_number' => 4],
            ['start_time' => '11:50', 'end_time' => '12:35', 'period_number' => 5],
            ['start_time' => '12:45', 'end_time' => '13:30', 'period_number' => 6],
            ['start_time' => '13:40', 'end_time' => '14:25', 'period_number' => 7],
        ];

        // Tworzenie godzin lekcyjnych
        foreach ($timeSlots as $timeSlot) {
            TimeSlot::create($timeSlot);
        }
        
        $this->command->info('Utworzono 7 godzin lekcyjnych.');
    }
}
