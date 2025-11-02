<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\TranscriptRequest;
use App\Models\Marksheet;
class StudentController extends Controller
{
    public function profile()
    {

        return view('student.profile');  // 
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // Validate photo upload
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'studentid' => 'nullable|string|max:20',
            'session' => 'nullable|string|max:20',
            'hall_name' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:20',
        ]);
        $data = $request->only(['name', 'email', 'phone', 'photo', 'father_name', 'mother_name', 'studentid', 'session', 'hall_name', 'room_number']);



        // If a new photo is uploaded, store it and add the path to the data array
        if ($request->hasFile('photo')) {



            $photoPath = $request->file('photo')->store('profile_photos', 'public'); // Store in the 'profile_photos' directory
            $data['photo'] = $photoPath;
        }


        // Update the user's profile in the database
        $user->update($data);

        // Redirect back with a success message
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required', // Validate current password
            'new_password' => 'required|min:8|confirmed', // Validate new password with confirmation
        ]);

        // Check if the current password matches the user's stored password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            // If passwords don't match, return with an error
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password if the current password is correct and the new passwords match
        Auth::user()->update([
            'password' => Hash::make($request->new_password), // Hash the new password before saving it
        ]);


        return redirect()->back()->with('success', 'Password updated successfully.');

    }

 public function dashboard()
    {
        $user = Auth::user();

        // Preload academic stats from marksheets
        $latestMarksheet = Marksheet::where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('generated_at', 'desc')
            ->first();

        $academicStats = [
            'cgpa' => $latestMarksheet ? round($latestMarksheet->cgpa, 2) : 0,
            'tgpa' => $latestMarksheet ? round($latestMarksheet->tgpa, 2) : 0,
            'credits_completed' => $latestMarksheet ? $latestMarksheet->credits_completed : 0,
            'current_year' => $user->academicYear ? $user->academicYear->name : 'N/A',
            'total_credits' => $latestMarksheet ? $latestMarksheet->total_credits : 120, // Default if not available
        ];

        // Preload recent marksheets (limit to 5 for results table)
        $marksheets = Marksheet::where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('generated_at', 'desc')
            ->take(5)
            ->with(['academicYear', 'term'])
            ->get()
            ->map(function ($marksheet) {
                return [
                    'session' => $marksheet->session,
                    'academic_year' => $marksheet->academicYear ? $marksheet->academicYear->name : 'N/A',
                    'term' => $marksheet->term ? $marksheet->term->name : 'N/A',
                    'tgpa' => round($marksheet->tgpa, 2),
                    'status' => $marksheet->status,
                ];
            });

        // Check if transcript is available
        $hasTranscript = TranscriptRequest::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->whereNotNull('result_file')
            ->exists();

        return view('student.dashboard', compact('user', 'academicStats', 'marksheets', 'hasTranscript'));
    }

    public function results()
    {
        return view('student.transcript-request');
    }

    public function getAcademicStats()
    {
        $user = Auth::user();
        $latestMarksheet = Marksheet::where('user_id', $user->id)
            ->where('status', 'published')
            ->orderBy('generated_at', 'desc')
            ->first();

        return response()->json([
            'cgpa' => $latestMarksheet ? round($latestMarksheet->cgpa, 2) : 0,
            'tgpa' => $latestMarksheet ? round($latestMarksheet->tgpa, 2) : 0,
            'credits_completed' => $latestMarksheet ? $latestMarksheet->credits_completed : 0,
            'current_year' => $user->academicYear ? $user->academicYear->name : 'N/A',
            'total_credits' => $latestMarksheet ? $latestMarksheet->total_credits : 120,
        ]);
    }


   
    public function viewResult(Request $request)
    {
        $query = TranscriptRequest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Apply filters if provided
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->where(function ($q) use ($status) {
                $q->where('payment_status', $status)
                    ->orWhere('admin_status', $status);
            });
        }

        $requests = $query->paginate(10);

        return view('student.update-request', compact('requests'));
    }

    /**
     * Download approved result file
     */
    public function downloadResult($id)
    {
        // First, get the request record with all its details for debugging
        $request = TranscriptRequest::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$request) {
            abort(404, 'Transcript request not found or you do not have permission to access it');
        }

        // Check if payment is completed
        if ($request->payment_status !== 'paid') {
            abort(403, 'Payment must be completed before downloading results');
        }

        // Check for either result_file or transcript_path
        $filePath = null;
        $fileName = 'transcript_' . ($request->academic_year ?? $request->year ?? 'unknown') . '_' . $request->term . '.pdf';

        if ($request->result_file && file_exists(storage_path('app/' . $request->result_file))) {
            $filePath = storage_path('app/' . $request->result_file);
        } elseif ($request->transcript_path && file_exists(storage_path('app/' . $request->transcript_path))) {
            $filePath = storage_path('app/' . $request->transcript_path);
        } elseif ($request->transcript_path && file_exists(storage_path('app/public/' . $request->transcript_path))) {
            // Check if file exists in storage/app/public directory
            $filePath = storage_path('app/public/' . $request->transcript_path);
        } elseif ($request->transcript_path && file_exists(public_path($request->transcript_path))) {
            // Check if file exists in public directory (some files might be stored there)
            $filePath = public_path($request->transcript_path);
        }

        if (!$filePath) {
            // For debugging, let's create a detailed error message
            $debugInfo = [
                'request_id' => $request->id,
                'status' => $request->status,
                'payment_status' => $request->payment_status,
                'result_file' => $request->result_file,
                'transcript_path' => $request->transcript_path,
                'result_file_exists' => $request->result_file ? file_exists(storage_path('app/' . $request->result_file)) : false,
                'transcript_path_exists_storage' => $request->transcript_path ? file_exists(storage_path('app/' . $request->transcript_path)) : false,
                'transcript_path_exists_storage_public' => $request->transcript_path ? file_exists(storage_path('app/public/' . $request->transcript_path)) : false,
                'transcript_path_exists_public' => $request->transcript_path ? file_exists(public_path($request->transcript_path)) : false,
                'storage_path_check' => $request->transcript_path ? storage_path('app/' . $request->transcript_path) : null,
                'storage_public_path_check' => $request->transcript_path ? storage_path('app/public/' . $request->transcript_path) : null,
                'public_path_check' => $request->transcript_path ? public_path($request->transcript_path) : null,
            ];

            abort(404, 'Result file not found. Debug info: ' . json_encode($debugInfo));
        }

        return response()->download($filePath, $fileName);
    }    /**
         * Delete unpaid transcript request
         */
    public function deleteRequest($id)
    {
        $request = TranscriptRequest::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('payment_status', '!=', 'paid')
            ->firstOrFail();

        $request->delete();

        return redirect()->route('student.viewResult')
            ->with('success', 'Request deleted successfully!');
    }

    /**
     * Check if a request already exists for the given year, session, and term
     */
    public function checkExistingRequest(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'year' => 'required',
            'session' => 'required',
            'term' => 'required',
        ]);

        // Check if a request exists for this user with the given parameters
        $exists = TranscriptRequest::where('user_id', Auth::id())
            ->where('academic_year', $request->year)
            ->where('session', $request->session)
            ->where('term', $request->term)
            ->exists();

        // Return JSON response
        return response()->json([
            'exists' => $exists
        ]);
    }
}
