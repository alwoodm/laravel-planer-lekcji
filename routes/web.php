<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Publiczna strona główna
Route::get('/', function () {
    return view('welcome');
});

// Strona dashboard (wymaga uwierzytelnienia)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Publiczne plany lekcji (dostępne bez logowania)
Route::get('/schedules/class/{classId}', [ScheduleController::class, 'showClassSchedule'])
    ->name('schedules.class');
Route::get('/schedules/teacher/{teacherId}', [ScheduleController::class, 'showTeacherSchedule'])
    ->name('schedules.teacher');

// Chronione trasy (wymagają uwierzytelnienia)
Route::middleware('auth')->group(function () {
    // Profil użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Mój plan lekcji
    Route::get('/my-schedule', [ScheduleController::class, 'showMySchedule'])->name('schedules.my');
});

require __DIR__.'/auth.php';
