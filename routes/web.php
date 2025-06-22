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


    
    Route::get('/student/view-result',[studentController::class, 'viewResult'])->name('student.viewResult');

    // Download Result
    Route::get('/student/download-result/{id}', [StudentController::class, 'downloadResult'])->name('student.downloadResult');
    
    // Delete Request (for unpaid requests only)
    Route::delete('/student/delete-request/{id}', [StudentController::class, 'deleteRequest'])->name('student.deleteRequest');
   
});

//admin




Route::prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Transcript Requests Management
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests');
    Route::put('/requests/{id}/status', [AdminController::class, 'updateStatus'])->name('update-status');
    Route::post('/requests/{id}/upload', [AdminController::class, 'uploadTranscript'])->name('upload-transcript');
    Route::get('/requests/{id}/download', [AdminController::class, 'downloadTranscript'])->name('download-transcript');
    Route::delete('/requests/{id}', [AdminController::class, 'deleteRequest'])->name('delete-request');
    
    // Bulk operations
    Route::post('/requests/bulk-update', [AdminController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
    
    // Export functionality
    Route::get('/requests/export', [AdminController::class, 'exportRequests'])->name('export-requests');
    
    // API endpoints for dashboard stats
    Route::get('/api/stats', [AdminController::class, 'getRequestStats'])->name('api.stats');
    
});













Route::middleware(['auth'])->group(function () {
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
});

// SSLCommerz callback routes (accessible without auth middleware)
// These routes should handle both GET and POST methods for maximum compatibility
Route::controller(PaymentController::class)
    ->prefix('sslcommerz')
    ->name('sslc.')
    ->group(function () {
        Route::match(['get', 'post'], 'success', 'paymentSuccess')->name('success');
        Route::match(['get', 'post'], 'failure', 'paymentFail')->name('failure');
        Route::match(['get', 'post'], 'cancel', 'paymentCancel')->name('cancel');
        Route::post('ipn', 'paymentIPN')->name('ipn');
    });









Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
