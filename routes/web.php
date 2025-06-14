<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;

Route::get('/', function () {
    return view('home');
});




Route::middleware('auth')->group(function () {

    // Route::get('/student/home',[StudentController::class,'home'])->name//('student.home');

     Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    
    Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');

    Route::post('/student/profile', [StudentController::class, 'store'])->name('student.profile.store');

    Route::get('/student/settings', fn () => view('student.settings'))->name('student.settings');

    Route::post('/student/settings', [StudentController::class, 'updatePassword'])->name('student.passwordSetting');
   
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
