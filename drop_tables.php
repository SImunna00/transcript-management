<?php

// Script to drop specified tables from the database

// Make sure we're in the Laravel application directory
$basePath = __DIR__;

// Load the Laravel environment
require $basePath . '/vendor/autoload.php';
$app = require_once $basePath . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Get the tables we want to drop
$tablesToDrop = [
    'courses',
    'departments',
    'course_enrollments',
    'semesters',
    'semester_results',
    'teacher_course',
    'results',
    'theory_marks',
    'lab_marks',
    'special_marks',
    'transcripts'
];

// Use Schema to drop the tables
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "Starting table cleanup process...\n";

// First drop all migration entries for these tables
try {
    $migrations = DB::table('migrations')
        ->where('migration', 'like', '%create_courses_table%')
        ->orWhere('migration', 'like', '%create_departments_table%')
        ->orWhere('migration', 'like', '%create_semesters_table%')
        ->orWhere('migration', 'like', '%create_semester_results_table%')
        ->orWhere('migration', 'like', '%create_results_table%')
        ->orWhere('migration', 'like', '%create_theory_marks_table%')
        ->orWhere('migration', 'like', '%create_lab_marks_table%')
        ->orWhere('migration', 'like', '%create_special_marks_table%')
        ->orWhere('migration', 'like', '%create_transcripts_table%')
        ->orWhere('migration', 'like', '%modify_courses_table%')
        ->get();

    echo "Found " . count($migrations) . " migrations to remove.\n";

    foreach ($migrations as $migration) {
        DB::table('migrations')->where('id', $migration->id)->delete();
        echo "Removed migration: {$migration->migration}\n";
    }
} catch (Exception $e) {
    echo "Error removing migrations: " . $e->getMessage() . "\n";
}

// Now drop the actual tables
foreach ($tablesToDrop as $table) {
    try {
        if (Schema::hasTable($table)) {
            // Disable foreign key checks to avoid constraint issues
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Schema::drop($table);
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            echo "Dropped table: {$table}\n";
        } else {
            echo "Table {$table} does not exist, skipping.\n";
        }
    } catch (Exception $e) {
        echo "Error dropping table {$table}: " . $e->getMessage() . "\n";
    }
}

echo "Table cleanup completed.\n";
echo "You can now run 'php artisan migrate' to recreate the tables fresh.\n";
