<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use Illuminate\Support\Facades\Route;

// Admin auth routes
Route::middleware(['web', 'guest:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Login routes
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store']);

    // Registration routes (restricted, only available in development)
    if (app()->environment('local')) {
        Route::get('register', [AdminRegisterController::class, 'create'])->name('register');
        Route::post('register', [AdminRegisterController::class, 'store']);
    }
});

Route::middleware(['web', 'auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Manual verification route (temporary solution)
    Route::post('/verify-user', [App\Http\Controllers\Auth\AdminVerificationController::class, 'verifyUser'])
        ->name('verify-user');
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');
});
