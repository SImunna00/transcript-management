<?php

use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use Illuminate\Support\Facades\Route;

// Teacher auth routes
Route::middleware('guest:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    // Login routes
    Route::get('login', [TeacherLoginController::class, 'create'])->name('login');
    Route::post('login', [TeacherLoginController::class, 'store']);

    // Registration routes
    Route::get('register', [TeacherRegisterController::class, 'create'])->name('register');
    Route::post('register', [TeacherRegisterController::class, 'store']);
});

Route::middleware('auth:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::post('logout', [TeacherLoginController::class, 'destroy'])->name('logout');
});
