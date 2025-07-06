<?php

use App\Http\Controllers\Auth\practice;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ResultApprovalController;
use App\Http\Controllers\Auth\EmailVerificationController;

Route::get('/', function () {
    return view('home');
});




Route::middleware('auth')->group(function () {

    // Route::get('/student/home',[StudentController::class,'home'])->name//('student.home');

    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    Route::get('/student/profile', [StudentController::class, 'profile'])->name('student.profile');

    Route::post('/student/profile', [StudentController::class, 'store'])->name('student.profile.store');

    Route::get('/student/settings', fn() => view('student.settings'))->name('student.settings');

    Route::post('/student/settings', [StudentController::class, 'updatePassword'])->name('student.passwordSetting');

    Route::get('/student/result', [studentController::class, 'results'])->name('student.applyResult');



    Route::get('/student/view-result', [studentController::class, 'viewResult'])->name('student.viewResult');

    // Download Result
    Route::get('/student/download-result/{id}', [StudentController::class, 'downloadResult'])->name('student.downloadResult');

    // Delete Request (for unpaid requests only)
    Route::delete('/student/delete-request/{id}', [StudentController::class, 'deleteRequest'])->name('student.deleteRequest');

});

//admin




Route::prefix('admin')->name('admin.')->group(function () {

    // Simple admin routes - only what you need
    Route::get('/requests', [AdminController::class, 'requests'])->name('Request');
    Route::post('/upload/{id}', [AdminController::class, 'uploadTranscript'])->name('upload');

    // Optional: Add dashboard if you want
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Result approval routes
    Route::get('/results/pending', [ResultApprovalController::class, 'index'])->name('results.pending');
    Route::get('/results/approved', [ResultApprovalController::class, 'approved'])->name('results.approved');
    Route::get('/results/{result}/preview', [ResultApprovalController::class, 'previewResult'])->name('results.preview');
    Route::post('/results/{result}/approve', [ResultApprovalController::class, 'approve'])->name('results.approve');
    Route::post('/results/bulk-approve', [ResultApprovalController::class, 'bulkApprove'])->name('results.bulkApprove');
});

// Teacher routes (protected by teacher auth guard)
Route::middleware('auth:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}/students', [TeacherController::class, 'courseStudents'])->name('courseStudents');
    Route::get('/courses/{course}/students/{student}/marks', [TeacherController::class, 'createMarkEntry'])->name('createMarkEntry');
    Route::post('/courses/{course}/students/{student}/marks', [TeacherController::class, 'storeMarkEntry'])->name('storeMarkEntry');
    Route::get('/results', [TeacherController::class, 'viewAllResults'])->name('results');
    Route::get('/results/{result}/preview', [TeacherController::class, 'previewResultPDF'])->name('previewResult');
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





//Route::get('/send',[practice::class,'send']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
