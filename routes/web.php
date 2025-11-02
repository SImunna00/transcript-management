git diff --stat
git status --shortgit diff --stat
git status --short<?php

use App\Http\Controllers\Auth\practice;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ResultApprovalController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\MarkEntryController;
use App\Http\Controllers\Admin\MarksheetController;


// Test routes for debugging
Route::get('/test-teacher-register', function () {
    return view('auth.teacher.register');
});

Route::get('/test-teacher-dashboard', function () {
    // Create dummy data to match what the controller would provide
    $stats = [
        "total_courses" => 5,
        "current_courses" => 3,
        "total_students" => 120,
        "pending_marks" => 15,
    ];
    $recent_results = [];

    return view("teacher.dashboard", compact("stats", "recent_results"));
});

Route::get('/', function () {
    return view('home');
});

// Test routes for debugging
Route::get('/test-route', function () {
    return "Test route is working!";
});

Route::get('/test-teacher-login', function () {
    return view('auth.teacher.login');
});

Route::get('/test-teacher-register', function () {
    return view('auth.teacher.register');
});

// Direct test for TeacherController dashboard method
Route::get('/test-teacher-controller', function () {
    $controller = new TeacherController();
    return $controller->dashboard();
});

// Include authentication routes
require __DIR__ . '/teacher-auth.php';
require __DIR__ . '/admin-auth.php';




// Student routes - using default web guard from Laravel Breeze
Route::middleware(['auth:web', 'verified'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentController::class, 'profile'])->name('profile');
    Route::post('/profile', [StudentController::class, 'store'])->name('profile.store');
    Route::get('/settings', fn() => view('student.settings'))->name('settings');

    Route::post('/settings', [StudentController::class, 'updatePassword'])->name('passwordSetting');

    Route::get('/result', [StudentController::class, 'results'])->name('applyResult');

    Route::get('/view-result', [StudentController::class, 'viewResult'])->name('viewResult');

    // Download Result
    Route::get('/download-result/{id}', [StudentController::class, 'downloadResult'])->name('downloadResult');

    // Delete Request (for unpaid requests only)
    Route::delete('/delete-request/{id}', [StudentController::class, 'deleteRequest'])->name('deleteRequest');

    // Check for existing transcript requests
    Route::post('/check-existing-request', [StudentController::class, 'checkExistingRequest'])->name('check-existing-request');

    // Document Request Routes


    // Payment Routes - Commented out as DocumentRequest model is removed
    // Route::get('/payment/{documentRequest}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    // Route::post('/payment/{documentRequest}/process', [PaymentController::class, 'process'])->name('payment.process');
    // Route::post('/payment/{documentRequest}/initiate', [PaymentController::class, 'initiateDocumentPayment'])->name('payment.initiate-document');

    Route::get('/academic-stats', [StudentController::class, 'getAcademicStats'])->name('academic-stats');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {


    // Transcript request routes
    Route::get('/transcript-requests', [AdminController::class, 'requests'])->name('transcript-requests.index');
    Route::get('/requests', [AdminController::class, 'requests'])->name('requests'); // Legacy URL support
    Route::get('/transcript-requests/{id}', [AdminController::class, 'show'])->name('transcript-requests.show');
    Route::post('/transcript-requests/bulk-generate', [AdminController::class, 'bulkGenerate'])->name('transcript-requests.bulk-generate');

    Route::post('/upload/{id}', [AdminController::class, 'uploadTranscript'])->name('upload');

    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/students', [AdminController::class, 'students'])->name('students.index');

    // Courses Management
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses.index');
    Route::get('/marks', [AdminController::class, 'marks'])->name('marks.index');
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('teachers.index');

    // Reports
    Route::get('/reports/transcripts', [AdminController::class, 'transcriptsReport'])->name('reports.transcripts');
    Route::get('/reports/analytics', [AdminController::class, 'analyticsReport'])->name('reports.analytics');

    // Settings
    Route::get('/settings/general', [AdminController::class, 'generalSettings'])->name('settings.general');
    Route::get('/settings/academic', [AdminController::class, 'academicSettings'])->name('settings.academic');
    Route::get('/settings/permissions', [AdminController::class, 'permissionsSettings'])->name('settings.permissions');

    // Result approval routes
    Route::get('/results/pending', [ResultApprovalController::class, 'index'])->name('results.pending');
    Route::get('/results/approved', [ResultApprovalController::class, 'approved'])->name('results.approved');
    Route::get('/results/{result}/preview', [ResultApprovalController::class, 'previewResult'])->name('results.preview');
    Route::post('/results/{result}/approve', [ResultApprovalController::class, 'approve'])->name('results.approve');
    Route::post('/results/bulk-approve', [ResultApprovalController::class, 'bulkApprove'])->name('results.bulkApprove');


    Route::resource('marksheets', MarksheetController::class);

    Route::post('marksheets/bulk-generate', [MarksheetController::class, 'bulkGenerate'])->name('marksheets.bulk-generate');
    Route::post('marksheets/quick-generate', [MarksheetController::class, 'quickGenerate'])->name('marksheets.quick-generate');
    Route::post('marksheets/bulk-download', [MarksheetController::class, 'bulkDownload'])->name('marksheets.bulk-download');
    Route::post('marksheets/bulk-regenerate', [MarksheetController::class, 'bulkRegenerate'])->name('marksheets.bulk-regenerate');
    Route::post('marksheets/{id}/recalculate', [MarksheetController::class, 'recalculate'])->name('marksheets.recalculate');
    Route::get('marksheets/{id}/download', [MarksheetController::class, 'downloadPDF'])->name('marksheets.download');
    Route::get('marksheets/{id}/transcript', [MarksheetController::class, 'generateTranscript'])->name('marksheets.transcript');
    Route::post('marksheets/preview', [MarksheetController::class, 'preview'])->name('marksheets.preview');
    Route::get('marksheets/{id}/preview', [MarksheetController::class, 'previewPDF'])->name('marksheets.preview-pdf');
    Route::post('marksheets/{id}/email', [MarksheetController::class, 'sendEmail'])->name('marksheets.email');

    Route::get('students-with-marks', [MarksheetController::class, 'getStudentsWithMarksApi'])->name('students-with-marks');
    Route::get('marks-preview', [MarksheetController::class, 'getMarksPreview'])->name('marks-preview');
});

// Teacher routes with authentication
Route::middleware(['web', 'auth:teacher'])
    ->prefix('teacher')
    ->name('teacher.')
    ->group(function () {
        Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');

        // Mark entry routes
        Route::get('/mark-entry', [TeacherController::class, 'markEntryForm'])->name('mark.entry');
        Route::post('/mark-entry/search-student', [TeacherController::class, 'searchStudent'])->name('mark.search-student');
        Route::get('/mark-entry/student/{student}', [TeacherController::class, 'studentMarks'])->name('mark.student');
        Route::post('/mark-entry/save', [TeacherController::class, 'saveMarks'])->name('mark.save');
        Route::get('/courses/{course}/students', [TeacherController::class, 'courseStudents'])->name('courseStudents');
        Route::get('/courses/{course}/students/{student}/marks', [TeacherController::class, 'createMarkEntry'])->name('createMarkEntry');

        //
        Route::post('/mark-entry/store', [TeacherController::class, 'storeMarkEntry'])->name('storeMarkEntry');

        Route::get('/results', [TeacherController::class, 'viewAllResults'])->name('results');
        Route::get('/results/{result}/preview', [TeacherController::class, 'previewResultPDF'])->name('previewResult');

        // Mark Entry System routes
        //show mark entry system
        Route::get('/mark-entry-system', [MarkEntryController::class, 'index'])->name('marks-entry-system');


        Route::get('/marksheet', [MarkEntryController::class, 'marksheetForm'])->name('marksheet');
        Route::get('/get-semesters', [MarkEntryController::class, 'getSemesters'])->name('get-semesters');
        Route::get('/get-courses', [MarkEntryController::class, 'getCourses'])->name('get-courses');
        Route::get('/get-students', [MarkEntryController::class, 'getStudents'])->name('get-students');
        Route::post('/save-marks', [MarkEntryController::class, 'saveMarks'])->name('save-marks');
        Route::post('/calculate-semester-result', [MarkEntryController::class, 'calculateSemesterResult'])->name('calculate-semester-result');
        Route::get('/generate-marksheet', [MarkEntryController::class, 'generateMarksheet'])->name('generate-marksheet');
        Route::get('/view-cgpa/{student_id}', [MarkEntryController::class, 'viewCGPA'])->name('view-cgpa');
    });














// Payment routes - accessible to authenticated students
Route::middleware(['auth'])->group(function () {
    Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    Route::get('/payment/initiate/{id}', [PaymentController::class, 'retryPayment'])->name('payment.initiate.retry');
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

// Explicit route for payment success for direct access (debugging)
Route::get('/payment/success', [PaymentController::class, 'paymentSuccessPage'])->name('payment.success.page');





//Route::get('/send',[practice::class,'send']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Development routes have been removed for production
