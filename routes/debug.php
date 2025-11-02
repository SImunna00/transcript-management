<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/debug/check-schema', function () {
    $output = [
        'courses_columns' => Schema::getColumnListing('courses'),
        'terms_columns' => Schema::getColumnListing('terms'),
        'academic_years_columns' => Schema::getColumnListing('academic_years'),
        'course_has_academic_year_id' => Schema::hasColumn('courses', 'academic_year_id'),
        'course_has_term_id' => Schema::hasColumn('courses', 'term_id'),
        'term_has_academic_year_id' => Schema::hasColumn('terms', 'academic_year_id'),
    ];

    return response()->json($output);
});
