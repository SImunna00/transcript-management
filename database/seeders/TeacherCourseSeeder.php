<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test teacher
        $teacher = Teacher::create([
            'name' => 'Dr. Md. Test Teacher',
            'email' => 'teacher@nstu.edu.bd',
            'password' => Hash::make('password'),
            'department' => 'Computer Science and Engineering',
            'designation' => 'Associate Professor',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // Create some courses
        $courses = [
            [
                'course_code' => 'CSE-101',
                'title' => 'Introduction to Computer Science',
                'credits' => 3.0,
                'department' => 'Computer Science and Engineering',
            ],
            [
                'course_code' => 'CSE-102',
                'title' => 'Programming Fundamentals',
                'credits' => 3.0,
                'department' => 'Computer Science and Engineering',
            ],
            [
                'course_code' => 'CSE-201',
                'title' => 'Data Structures',
                'credits' => 4.0,
                'department' => 'Computer Science and Engineering',
            ],
            [
                'course_code' => 'CSE-202',
                'title' => 'Algorithms',
                'credits' => 3.0,
                'department' => 'Computer Science and Engineering',
            ],
            [
                'course_code' => 'CSE-301',
                'title' => 'Database Systems',
                'credits' => 3.0,
                'department' => 'Computer Science and Engineering',
            ],
        ];

        foreach ($courses as $course) {
            $c = Course::create($course);

            // Assign the course to the teacher for the current academic year and term
            $teacher->courses()->attach($c->id, [
                'academic_year' => '2025',
                'term' => 'Spring',
            ]);
        }

        // Get existing students or create test students
        $students = User::where('email', 'like', '%@student.nstu.edu.bd')->take(10)->get();

        if ($students->isEmpty()) {
            // Create test students if none exist
            for ($i = 1; $i <= 10; $i++) {
                $student = User::create([
                    'name' => 'Test Student ' . $i,
                    'email' => 'student' . $i . '@student.nstu.edu.bd',
                    'password' => Hash::make('password'),
                    'studentid' => '20250' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'email_verified_at' => now(),
                ]);

                $students->push($student);
            }
        }

        // Enroll students in courses
        foreach ($students as $student) {
            foreach (Course::all() as $course) {
                // Random enrollment - not all students take all courses
                if (rand(0, 1)) {
                    $student->courses()->attach($course->id, [
                        'academic_year' => '2025',
                        'term' => 'Spring',
                    ]);
                }
            }
        }
    }
}
