<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/terms/{yearId}', [ApiController::class, 'getTerms']);
Route::get('/courses/{yearId}/{termId}', [ApiController::class, 'getCourses']);
Route::get('/students/{courseId}/{yearId}/{termId}', [ApiController::class, 'getStudents']);
Route::post('/mark-entry/save-progress', [ApiController::class, 'saveProgress']);

