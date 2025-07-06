<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test teacher account
        Teacher::create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'department' => 'Computer Science & Engineering',
            'phone' => '01700000000',
        ]);

        // Create a few more teachers for testing
        Teacher::create([
            'name' => 'Dr. Anika Rahman',
            'email' => 'anika.rahman@example.com',
            'password' => Hash::make('password'),
            'department' => 'Electrical Engineering',
            'phone' => '01712345678',
        ]);

        Teacher::create([
            'name' => 'Dr. Kamal Hossain',
            'email' => 'kamal.hossain@example.com',
            'password' => Hash::make('password'),
            'department' => 'Computer Science & Engineering',
            'phone' => '01798765432',
        ]);
    }
}
