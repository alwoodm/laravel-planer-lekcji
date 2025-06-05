<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\TimeSlot;
use Illuminate\Support\Collection;

class ScheduleController extends Controller
{
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
     * Wyświetla plan lekcji dla zalogowanego użytkownika
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function showMySchedule(Request $request): View
    {
        $user = $request->user();
        
        if ($user->isTeacher()) {
            return $this->showTeacherSchedule($user->id);
        } elseif ($user->isStudent()) {
            $class = $user->classes()->first();
            if ($class) {
                return $this->showClassSchedule($class->id);
            } else {
                return view('schedules.empty', [
                    'message' => 'Nie jesteś przypisany do żadnej klasy.',
                    'title' => 'Brak przypisanej klasy'
                ]);
            }
        }
        
        return view('schedules.empty', [
            'message' => 'Nie znaleziono planu lekcji dla Twojej roli.',
            'title' => 'Brak planu lekcji'
        ]);
    }
    
    /**
     * Wyświetla plan lekcji dla wybranej klasy
     *
     * @param  int  $classId
     * @return \Illuminate\View\View
     */
    public function showClassSchedule(int $classId): View
    {
        $data = $this->prepareClassSchedule($classId);
        return view('schedules.class', $data);
    }
    
    /**
     * Wyświetla plan lekcji dla wybranego nauczyciela
     *
     * @param  int  $teacherId
     * @return \Illuminate\View\View
     */
    public function showTeacherSchedule(int $teacherId): View
    {
        $data = $this->prepareTeacherSchedule($teacherId);
        return view('schedules.teacher', $data);
    }
    
    /**
     * Przygotowuje dane planu lekcji dla klasy
     *
     * @param  int  $classId
     * @return array
     */
    public function prepareClassSchedule(int $classId): array
    {
        $class = SchoolClass::findOrFail($classId);
        $timeSlots = TimeSlot::orderBy('period_number')->get();
        $schedules = Schedule::where('class_id', $classId)
            ->with(['subject', 'teacher', 'timeSlot'])
            ->get();
        
        $weeklySchedule = $this->formatWeeklySchedule($schedules, $timeSlots);
        
        return [
            'class' => $class,
            'timeSlots' => $timeSlots,
            'weeklySchedule' => $weeklySchedule,
            'weekDays' => $this->weekDays,
            'polishDays' => $this->polishDays
        ];
    }
    
    /**
     * Przygotowuje dane planu lekcji dla nauczyciela
     *
     * @param  int  $teacherId
     * @return array
     */
    public function prepareTeacherSchedule(int $teacherId): array
    {
        $teacher = User::findOrFail($teacherId);
        $timeSlots = TimeSlot::orderBy('period_number')->get();
        $schedules = Schedule::where('user_id', $teacherId)
            ->with(['class', 'subject', 'timeSlot'])
            ->get();
        
        $weeklySchedule = $this->formatWeeklySchedule($schedules, $timeSlots);
        
        return [
            'teacher' => $teacher,
            'timeSlots' => $timeSlots,
            'weeklySchedule' => $weeklySchedule,
            'weekDays' => $this->weekDays,
            'polishDays' => $this->polishDays
        ];
    }
    
    /**
     * Formatuje dane do tabeli tygodniowej
     *
     * @param  \Illuminate\Support\Collection  $schedules
     * @param  \Illuminate\Support\Collection  $timeSlots
     * @return array
     */
    protected function formatWeeklySchedule(Collection $schedules, Collection $timeSlots): array
    {
        $weeklySchedule = [];
        
        foreach ($this->weekDays as $day) {
            $weeklySchedule[$day] = [];
            
            foreach ($timeSlots as $timeSlot) {
                $weeklySchedule[$day][$timeSlot->id] = $schedules->filter(function ($schedule) use ($timeSlot, $day) {
                    return $schedule->time_slot_id == $timeSlot->id && $schedule->day_of_week == $day;
                })->first();
            }
        }
        
        return $weeklySchedule;
    }
}
