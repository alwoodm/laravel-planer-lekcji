<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\TimeSlot;
use App\Models\SchoolClass;

class ClassSchedule extends Component
{
    /**
     * ID klasy
     *
     * @var int
     */
    public $classId;
    
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
        $class = SchoolClass::find($this->classId);
        
        if (!$class) {
            return view('livewire.empty-schedule', [
                'message' => 'Klasa nie została znaleziona.'
            ]);
        }
        
        $schedules = Schedule::where('class_id', $this->classId)
            ->with(['subject', 'timeSlot', 'teacher'])
            ->forWeek()
            ->get();
        
        $weeklySchedule = $this->formatWeeklySchedule($schedules);
        
        return view('livewire.class-schedule', [
            'class' => $class,
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
