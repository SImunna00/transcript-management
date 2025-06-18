<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

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

    Route::get('/student/result',[studentController::class, 'results'])->name('student.applyResult');


    
    Route::get('/student/view-result',[studentController::class, 'view_Result'])->name('student.viewResult');
   
});



Route::get('/admin/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard'); 


Route::get('/admin/upload',[AdminController::class, 'Request'])->name('admin.Request'); 










Route::controller(PaymentController::class)
    ->prefix('sslcommerz') // Prefix to avoid conflicts
    ->name('sslc.')
    ->group(function () {
        Route::post('success', 'paymentSuccess')->name('success');
        Route::post('failure', 'paymentFail')->name('failure');
        Route::post('cancel', 'paymentCancel')->name('cancel');
        Route::post('ipn', 'paymentIPN')->name('ipn');
    });

Route::post('payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
Route::get('payment/success', [PaymentController::class, 'paymentSuccess'])->name('sslc.success');
Route::get('payment/fail', [PaymentController::class, 'paymentFail'])->name('sslc.failure');
Route::get('payment/cancel', [PaymentController::class, 'paymentCancel'])->name('sslc.cancel');

































Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
