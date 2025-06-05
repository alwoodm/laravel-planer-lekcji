<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\TimeSlot;

class DashboardController extends Controller
{
    /**
     * Wyświetla dashboard dostosowany do roli użytkownika
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            // Statystyki dla administratora
            $stats = [
                'teachers' => User::where('role', 'teacher')->count(),
                'students' => User::where('role', 'student')->count(),
                'classes' => SchoolClass::count(),
                'subjects' => Subject::count(),
                'schedules' => Schedule::count(),
            ];

            return view('dashboard', compact('stats'));
        } elseif ($user->isTeacher()) {
            // Przekierowanie do widoku planu nauczyciela
            $teacherId = $user->id;
            $scheduleController = new ScheduleController();
            $scheduleData = $scheduleController->prepareTeacherSchedule($teacherId);
            
            return view('dashboard', $scheduleData);
        } elseif ($user->isStudent()) {
            // Pobierz klasę ucznia
            $studentClass = $user->classes()->first();
            
            if ($studentClass) {
                $scheduleController = new ScheduleController();
                $scheduleData = $scheduleController->prepareClassSchedule($studentClass->id);
                
                return view('dashboard', $scheduleData);
            } else {
                // Uczeń nie jest przypisany do żadnej klasy
                return view('dashboard', ['noClass' => true]);
            }
        }
        
        // Domyślny widok, gdyby rola nie była zdefiniowana
        return view('dashboard');
    }
}
