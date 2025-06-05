<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

// Publiczne routes
Route::get('/', function () {
    return auth()->check() ? redirect('/dashboard') : view('welcome');
});

// Publiczne plany lekcji
Route::get('/plan/klasa/{class}', [ScheduleController::class, 'showClassSchedule'])
    ->name('schedule.class');
Route::get('/plan/nauczyciel/{teacher}', [ScheduleController::class, 'showTeacherSchedule'])
    ->name('schedule.teacher');

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard i plany lekcji
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/moj-plan', [ScheduleController::class, 'showMySchedule'])->name('schedule.my');
    
    // Profil użytkownika
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        // Te trasy są dodatkowo chronione przez middleware 'role:admin'
        Route::get('/admin-stats', [DashboardController::class, 'adminStats'])->name('admin.stats');
    });
});

// Breeze routes
require __DIR__.'/auth.php';
