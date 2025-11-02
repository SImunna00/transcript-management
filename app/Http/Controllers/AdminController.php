<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranscriptRequest;
use App\Models\User; // Import User model
use App\Models\TheoryMark;
use App\Models\LabMark;
use App\Models\SpecialMark;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Marksheet;
use App\Models\AcademicYear;
use App\Models\Term;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics.
     */
    public function dashboard()
    {
        $stats = [
            'total_requests' => TranscriptRequest::count(),
            'pending_requests' => TranscriptRequest::where('status', 'pending')->count(),
            'completed_requests' => TranscriptRequest::where('status', 'completed')->count(),
            'total_students' => User::count(), // Assuming User model is for students
        ];

        $recentRequests = TranscriptRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentRequests'));
    }

    /**
     * Display all transcript requests with filtering.
     */
    public function requests()
    {
        $query = TranscriptRequest::with('user');

        // Apply filters based on request parameters
        if (request('status')) {
            $status = request('status');
            if ($status === 'completed') {
                // Filter by actual status column for completed requests
                $query->where('status', 'completed');
            } else {
                // Filter by payment_status for pending, paid, failed
                $query->where('payment_status', $status);
            }
        }

        if (request('year')) {
            $query->where('academic_year', request('year'));
        }

        if (request('term')) {
            $query->where('term', request('term'));
        }

        if (request('search')) {
            $searchTerm = request('search');
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('studentid', 'like', "%{$searchTerm}%")
                    ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        // Calculate statistics
        $stats = [
            'total_requests' => TranscriptRequest::count(),
            'pending_requests' => TranscriptRequest::where('payment_status', 'pending')->count(),
            'completed_requests' => TranscriptRequest::where('status', 'completed')->count(),
            'total_revenue' => TranscriptRequest::where('payment_status', 'paid')->sum('amount'),
        ];

        // Calculate status counts for tabs
        $statusCounts = [
            'all' => TranscriptRequest::count(),
            'pending' => TranscriptRequest::where('payment_status', 'pending')->count(),
            'paid' => TranscriptRequest::where('payment_status', 'paid')->where('status', '!=', 'completed')->count(),
            'completed' => TranscriptRequest::where('status', 'completed')->count(),
        ];

        return view('admin.transcript-requests.requests', compact('requests', 'stats', 'statusCounts'));
    }

    /**
     * Upload transcript file and update the request status.
     */
    public function uploadTranscript(Request $request, $id)
    {
        try {
            // Handle payment confirmation action
            if ($request->input('action') === 'mark_paid') {
                $transcriptRequest = TranscriptRequest::findOrFail($id);
                $transcriptRequest->update(['payment_status' => 'paid']);
                return redirect()->back()->with('success', '✅ Payment confirmed for ' . $transcriptRequest->user->name . '! Now ready for transcript approval.');
            }

            // Handle transcript approval - copy file path from marksheets table
            $transcriptRequest = TranscriptRequest::findOrFail($id);
            $studentName = $transcriptRequest->user->name ?? 'Unknown Student';
            $studentId = $transcriptRequest->user->studentid ?? 'N/A';

            // Prevent duplicate approval
            if ($transcriptRequest->status === 'completed') {
                return redirect()->back()->with('error', '⚠️ This transcript request has already been approved for ' . $studentName . '.');
            }

            // Ensure payment is confirmed before approval
            if ($transcriptRequest->payment_status !== 'paid') {
                return redirect()->back()->with('error', '❌ Payment must be confirmed before approving transcript for ' . $studentName . '. Please confirm payment first.');
            }

            // Search for marksheet with multiple strategies
            $marksheet = null;

            // Strategy 1: Try with relationships using string names
            try {
                $marksheet = Marksheet::where('user_id', $transcriptRequest->user_id)
                    ->where('session', $transcriptRequest->session)
                    ->whereNotNull('file_path')
                    ->whereHas('academicYear', function ($query) use ($transcriptRequest) {
                        $query->where('name', $transcriptRequest->academic_year);
                    })
                    ->whereHas('term', function ($query) use ($transcriptRequest) {
                        $query->where('name', $transcriptRequest->term);
                    })
                    ->first();
            } catch (\Exception $e) {
                // Continue to next strategy if relationship fails
            }

            // Strategy 2: Direct ID lookup if relationships failed
            if (!$marksheet) {
                $academicYear = AcademicYear::where('name', $transcriptRequest->academic_year)->first();
                $term = Term::where('name', $transcriptRequest->term)->first();

                if ($academicYear && $term) {
                    $marksheet = Marksheet::where('user_id', $transcriptRequest->user_id)
                        ->where('session', $transcriptRequest->session)
                        ->where('academic_year_id', $academicYear->id)
                        ->where('term_id', $term->id)
                        ->whereNotNull('file_path')
                        ->first();
                }
            }

            // Strategy 3: Flexible search by session and user only (as fallback)
            if (!$marksheet) {
                $marksheet = Marksheet::where('user_id', $transcriptRequest->user_id)
                    ->where('session', $transcriptRequest->session)
                    ->whereNotNull('file_path')
                    ->latest('created_at')
                    ->first();
            }

            // Check if marksheet was found and has valid file path
            if (!$marksheet) {
                return redirect()->back()->with('error', '📄 No marksheet found for ' . $studentName . ' (ID: ' . $studentId . ') with session "' . $transcriptRequest->session . '", year "' . $transcriptRequest->academic_year . '", term "' . $transcriptRequest->term . '". Please generate the marksheet first.');
            }

            if (!$marksheet->file_path || trim($marksheet->file_path) === '') {
                return redirect()->back()->with('error', '📄 Marksheet found for ' . $studentName . ' but no file path is available. Please regenerate the marksheet with proper file.');
            }

            // Verify the file actually exists
            $fullPath = storage_path('app/public/' . ltrim($marksheet->file_path, '/'));
            if (!file_exists($fullPath)) {
                return redirect()->back()->with('error', '📁 Marksheet file not found on server for ' . $studentName . '. File path: ' . $marksheet->file_path . '. Please regenerate the marksheet.');
            }

            // Update the request record with the marksheet file path and status
            $transcriptRequest->update([
                'transcript_path' => $marksheet->file_path,
                'status' => 'completed',
                'uploaded_at' => now(),
            ]);

            // Log the successful approval
            \Log::info('Transcript approved successfully', [
                'student_name' => $studentName,
                'student_id' => $studentId,
                'transcript_request_id' => $transcriptRequest->id,
                'marksheet_id' => $marksheet->id,
                'file_path' => $marksheet->file_path,
                'approved_by' => auth()->user()->name ?? 'Admin',
                'approved_at' => now()
            ]);

            // Optionally, send a notification to the user
            // $transcriptRequest->user->notify(new \App\Notifications\TranscriptReady($transcriptRequest));

            return redirect()->back()->with('success', '🎉 Transcript approved successfully for ' . $studentName . ' (ID: ' . $studentId . ')! The marksheet has been linked and the student can now download their transcript.');

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Transcript approval error', [
                'transcript_request_id' => $id,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'admin_user' => auth()->user()->name ?? 'Unknown'
            ]);

            return redirect()->back()->with('error', '❌ An unexpected error occurred while approving the transcript: ' . $e->getMessage() . '. Please try again or contact system administrator.');
        }
    }

    public function students()
    {
        $students = User::whereNotNull('studentid')->get(); // Assuming students have a studentid
        return view('admin.students.index', compact('students'));
    }

    public function courses()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function marks()
    {
        $theoryMarks = TheoryMark::with(['user', 'course'])->get();
        $labMarks = LabMark::with(['user', 'course'])->get();
        $specialMarks = SpecialMark::with(['user', 'course'])->get();

        return view('admin.marks.index', compact('theoryMarks', 'labMarks', 'specialMarks'));
    }

    public function teachers()
    {
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function transcriptsReport()
    {
        $transcriptRequests = TranscriptRequest::with('user')->get();
        return view('admin.reports.transcripts', compact('transcriptRequests'));
    }

    public function analyticsReport()
    {
        $totalStudents = User::count();
        $totalTeachers = Teacher::count();
        $totalCourses = Course::count();
        $totalTranscriptRequests = TranscriptRequest::count();
        $pendingTranscriptRequests = TranscriptRequest::where('status', 'pending')->count();
        $completedTranscriptRequests = TranscriptRequest::where('status', 'completed')->count();

        return view('admin.reports.analytics', compact(
            'totalStudents',
            'totalTeachers',
            'totalCourses',
            'totalTranscriptRequests',
            'pendingTranscriptRequests',
            'completedTranscriptRequests'
        ));
    }

    public function generalSettings()
    {
        return view('admin.settings.general');
    }

    public function academicSettings()
    {
        return view('admin.settings.academic');
    }

    public function permissionsSettings()
    {
        return view('admin.settings.permissions');
    }

    public function show($id)
    {
        $request = TranscriptRequest::with('user')->findOrFail($id);
        return view('admin.requests-show', compact('request'));
    }

    public function bulkGenerate(Request $request)
    {
        // This is a placeholder for the bulk generation logic
        return redirect()->route('admin.transcript-requests.index')->with('success', 'Bulk generation is not yet implemented.');
    }
}
