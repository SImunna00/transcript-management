<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranscriptRequest;


class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_requests' => TranscriptRequest::count(),
            'pending_requests' => TranscriptRequest::where('admin_status', 'pending')->count(),
            'approved_requests' => TranscriptRequest::where('admin_status', 'approved')->count(),
            'paid_requests' => TranscriptRequest::where('payment_status', 'paid')->count(),
        ];

        $recent_requests = TranscriptRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_requests'));
    }

    /**
     * Display all transcript requests with filtering
     */
    
 public function requests()
    {
        $requests = TranscriptRequest::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.requests', compact('requests'));
    }

    /**
     * Upload transcript file
     */


// Add this method to your AdminController class

public function uploadTranscript(Request $request, $id)
{
    try {
        // Debug logging
      

        // Validate the uploaded file
        $request->validate([
            'transcript' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ], [
            'transcript.required' => 'Please select a PDF file to upload.',
            'transcript.mimes' => 'Only PDF files are allowed.',
            'transcript.max' => 'File size must be less than 10MB.'
        ]);

        // Find the transcript request (adjust model name as needed)
        $transcriptRequest = TranscriptRequest::findOrFail($id);
        // or if your model is different:
        // $transcriptRequest = \App\Models\Request::findOrFail($id);
        
        if ($request->hasFile('transcript')) {
            $file = $request->file('transcript');
            
         
            
            // Create directory if it doesn't exist
            $uploadPath = storage_path('app/public/transcripts');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Generate unique filename
            $fileName = 'transcript_' . $transcriptRequest->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file
            $filePath = $file->storeAs('transcripts', $fileName, 'public');
            
            
            
            // Update the request record
            $transcriptRequest->update([
                'transcript_path' => $filePath,
                'status' => 'completed', // adjust field name as needed
                'uploaded_at' => now(),
            ]);
            
            return redirect()->back()->with('success', 'Transcript uploaded successfully for ' . ($transcriptRequest->user->name ?? 'student') . '!');
        }
        
        return redirect()->back()->with('error', 'No file was received. Please try again.');
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        
        return redirect()->back()->withErrors($e->errors())->withInput();
        
    } catch (\Exception $e) {
      
        return redirect()->back()->with('error', 'Upload failed: ' . $e->getMessage());
    }
}



}
