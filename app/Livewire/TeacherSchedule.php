<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Models\User;

class TeacherSchedule extends Component
{
    /**
     * ID nauczyciela
     *
     * @var int
     */
    public $teacherId;
    
    /**
     * Lista dni tygodnia
     *
     * @var array
     */
    protected $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    
    /**
     * Polskie nazwy dni tygodnia
     *
     * @var array
     */
    protected $polishDays = [
        'Monday' => 'Poniedziałek',
        'Tuesday' => 'Wtorek',
        'Wednesday' => 'Środa',
        'Thursday' => 'Czwartek',
        'Friday' => 'Piątek'
    ];

    /**
     * Render komponentu
     */
    public function render()
    {
        $teacher = User::where('role', 'teacher')->find($this->teacherId);
        
        if (!$teacher) {
            return view('livewire.empty-schedule', [
                'message' => 'Nauczyciel nie został znaleziony.'
            ]);
        }
        
        $schedules = Schedule::where('user_id', $this->teacherId)
            ->with(['subject', 'timeSlot', 'class'])
            ->forWeek()
            ->get();
        
        $weeklySchedule = $this->formatWeeklySchedule($schedules);
        
        return view('livewire.teacher-schedule', [
            'teacher' => $teacher,
            'weeklySchedule' => $weeklySchedule,
            'timeSlots' => TimeSlot::orderBy('period_number')->get(),
            'weekDays' => $this->weekDays,
            'polishDays' => $this->polishDays,
        ]);
    }
    
    /**
     * Formatuje dane harmonogramu do formatu tygodniowego
     * 
     * @param  \Illuminate\Support\Collection  $schedules
     * @return array
     */
    protected function formatWeeklySchedule($schedules)
    {
        $formattedSchedule = [];
        
        foreach ($this->weekDays as $day) {
            foreach (TimeSlot::orderBy('period_number')->get() as $timeSlot) {
                $formattedSchedule[$day][$timeSlot->id] = $schedules
                    ->where('day_of_week', $day)
                    ->where('time_slot_id', $timeSlot->id)
                    ->first();
            }
        }
        
        return $formattedSchedule;
    }
}
