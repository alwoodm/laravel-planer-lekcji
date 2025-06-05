<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuwamy istniejących użytkowników (oprócz Admina, który tworzony jest w DatabaseSeeder)
        User::whereNot('email', 'admin@szkola.pl')->delete();
        
        // Lista nauczycieli
        $teachers = [
            ['first_name' => 'Anna', 'last_name' => 'Kowalska'],
            ['first_name' => 'Piotr', 'last_name' => 'Nowak'],
            ['first_name' => 'Maria', 'last_name' => 'Wiśniewska'],
            ['first_name' => 'Jan', 'last_name' => 'Dąbrowski'],
            ['first_name' => 'Katarzyna', 'last_name' => 'Lewandowska'],
            ['first_name' => 'Tomasz', 'last_name' => 'Wójcik'],
        ];

        // Tworzenie kont nauczycieli
        foreach ($teachers as $teacher) {
            $firstName = $teacher['first_name'];
            $lastName = $teacher['last_name'];
            $email = strtolower(Str::ascii($firstName . '.' . $lastName . '@szkola.pl'));
            
            User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }

        // Tworzenie kont uczniów (30 uczniów - po 5 dla każdej z 6 klas)
        $faker = \Faker\Factory::create('pl_PL');
        
        for ($i = 1; $i <= 30; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            
            User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => strtolower(Str::ascii($firstName . '.' . $lastName . '@uczen.szkola.pl')),
                'password' => Hash::make('password'),
                'role' => 'student',
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);
        }
        
        $this->command->info('Utworzono 6 nauczycieli i 30 uczniów.');
    }
}
