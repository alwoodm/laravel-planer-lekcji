<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tworzenie administratora systemu (tylko jeśli nie istnieje)
        User::firstOrCreate(
            ['email' => 'admin@szkola.pl'],
            [
                'name' => 'Admin System',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'first_name' => 'Admin',
                'last_name' => 'System',
            ]
        );
        
        // Uruchomienie poszczególnych seederów
        $this->call([
            UserSeeder::class,
            SubjectSeeder::class,
            ClassSeeder::class,
            TimeSlotSeeder::class,
            StudentClassAssignmentSeeder::class,
            ScheduleSeeder::class,
        ]);
        
        // Informacja o zakończeniu seedowania
        $this->command->info('Baza danych została zainicjowana pomyślnie!');
        $this->command->info('Dane logowania administratora:');
        $this->command->info('Email: admin@szkola.pl');
        $this->command->info('Hasło: password');
    }
}
