<?php

use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use Illuminate\Support\Facades\Route;

// Direct teacher auth routes without nesting or prefixes
Route::middleware(['web', 'guest:teacher'])->group(function () {
    // Login routes
    Route::get('/teacher/login', [TeacherLoginController::class, 'create'])->name('teacher.login');
    Route::post('/teacher/login', [TeacherLoginController::class, 'store'])->name('teacher.login.store');

    // Registration routes
    Route::get('/teacher/register', [TeacherRegisterController::class, 'create'])->name('teacher.register');
    Route::post('/teacher/register', [TeacherRegisterController::class, 'store'])->name('teacher.register.store');
});

// Teacher logout route
Route::middleware(['web', 'auth:teacher'])->group(function () {
    Route::post('/teacher/logout', [TeacherLoginController::class, 'destroy'])->name('teacher.logout');
});
