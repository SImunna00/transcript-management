<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
    public function requests(Request $request)
    {
        $query = TranscriptRequest::with('user');

        // Apply filters
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('admin_status')) {
            $query->where('admin_status', $request->admin_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('student_id', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.requests', compact('requests'));
    }

    /**
     * Update request status
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'admin_status' => 'required|in:pending,processing,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Invalid input data.');
        }

        try {
            $transcriptRequest = TranscriptRequest::findOrFail($id);
            
            $transcriptRequest->update([
                'admin_status' => $request->admin_status,
                'admin_notes' => $request->admin_notes,
                'admin_updated_at' => now(),
            ]);

            // If approved, send notification (you can implement email notification here)
            if ($request->admin_status === 'approved') {
                // Optional: Send email notification to student
                // Mail::to($transcriptRequest->user->email)->send(new TranscriptApprovedMail($transcriptRequest));
            }

            return redirect()->back()->with('success', 'Request status updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update status. Please try again.');
        }
    }

    /**
     * Upload transcript file
     */
    public function uploadTranscript(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'result_file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Please upload a valid PDF file (max 10MB).');
        }

        try {
            $transcriptRequest = TranscriptRequest::findOrFail($id);

            // Check if payment is completed
            if ($transcriptRequest->payment_status !== 'paid') {
                return redirect()->back()
                    ->with('error', 'Cannot upload transcript for unpaid requests.');
            }

            // Delete old file if exists
            if ($transcriptRequest->result_file && Storage::exists($transcriptRequest->result_file)) {
                Storage::delete($transcriptRequest->result_file);
            }

            // Store new file
            $file = $request->file('result_file');
            $filename = 'transcripts/' . time() . '_' . $transcriptRequest->user->student_id . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('', $filename, 'local');

            // Update database
            $updateData = [
                'result_file' => $filePath,
                'result_uploaded_at' => now(),
            ];

            // Auto approve if checkbox is checked
            if ($request->has('auto_approve')) {
                $updateData['admin_status'] = 'approved';
                $updateData['admin_updated_at'] = now();
            }

            $transcriptRequest->update($updateData);

            $message = 'Transcript uploaded successfully!';
            if ($request->has('auto_approve')) {
                $message .= ' Request has been automatically approved.';
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to upload transcript. Please try again.');
        }
    }

    /**
     * Download transcript file
     */
    public function downloadTranscript($id)
    {
        try {
            $transcriptRequest = TranscriptRequest::findOrFail($id);

            if (!$transcriptRequest->result_file || !Storage::exists($transcriptRequest->result_file)) {
                abort(404, 'Transcript file not found.');
            }

            $filename = 'transcript_' . $transcriptRequest->user->student_id . '_' . 
                       $transcriptRequest->year . '_' . 
                       str_replace(' ', '_', $transcriptRequest->term) . '.pdf';

            return Storage::download($transcriptRequest->result_file, $filename);

        } catch (\Exception $e) {
            abort(404, 'Transcript file not found.');
        }
    }

    /**
     * Delete transcript request (admin only, for emergency cases)
     */
    public function deleteRequest($id)
    {
        try {
            $transcriptRequest = TranscriptRequest::findOrFail($id);

            // Delete associated file if exists
            if ($transcriptRequest->result_file && Storage::exists($transcriptRequest->result_file)) {
                Storage::delete($transcriptRequest->result_file);
            }

            $transcriptRequest->delete();

            return redirect()->back()->with('success', 'Request deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete request. Please try again.');
        }
    }

    /**
     * Get request statistics for dashboard
     */
    public function getRequestStats()
    {
        $stats = [
            'total' => TranscriptRequest::count(),
            'pending_payment' => TranscriptRequest::where('payment_status', 'pending')->count(),
            'paid' => TranscriptRequest::where('payment_status', 'paid')->count(),
            'pending_review' => TranscriptRequest::where('admin_status', 'pending')->count(),
            'processing' => TranscriptRequest::where('admin_status', 'processing')->count(),
            'approved' => TranscriptRequest::where('admin_status', 'approved')->count(),
            'rejected' => TranscriptRequest::where('admin_status', 'rejected')->count(),
            
            // Monthly stats
            'this_month' => TranscriptRequest::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'last_month' => TranscriptRequest::whereMonth('created_at', now()->subMonth()->month)
                ->whereYear('created_at', now()->subMonth()->year)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Bulk update request status
     */
    public function bulkUpdateStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_ids' => 'required|array',
            'request_ids.*' => 'exists:transcript_requests,id',
            'admin_status' => 'required|in:pending,processing,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Invalid input data.');
        }

        try {
            DB::beginTransaction();

            TranscriptRequest::whereIn('id', $request->request_ids)
                ->update([
                    'admin_status' => $request->admin_status,
                    'admin_notes' => $request->admin_notes,
                    'admin_updated_at' => now(),
                ]);

            DB::commit();

            $count = count($request->request_ids);
            return redirect()->back()->with('success', "Successfully updated {$count} requests!");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update requests. Please try again.');
        }
    }

    /**
     * Export requests to CSV
     */
    public function exportRequests(Request $request)
    {
        $query = TranscriptRequest::with('user');

        // Apply same filters as the main requests page
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }
        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('admin_status')) {
            $query->where('admin_status', $request->admin_status);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        $filename = 'transcript_requests_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($requests) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Request ID',
                'Student Name',
                'Student ID',
                'Email',
                'Academic Year',
                'Term',
                'Amount',
                'Payment Status',
                'Admin Status',
                'Request Date',
                'Payment Date',
                'Admin Notes',
                'Transaction ID'
            ]);

            // CSV data
            foreach ($requests as $request) {
                fputcsv($file, [
                    $request->id,
                    $request->user->name ?? 'N/A',
                    $request->user->student_id ?? 'N/A',
                    $request->user->email ?? 'N/A',
                    $request->year ?? 'N/A',
                    $request->term ?? 'N/A',
                    $request->amount ?? 0,
                    $request->payment_status,
                    $request->admin_status,
                    $request->created_at->format('Y-m-d H:i:s'),
                    $request->payment_completed_at ? $request->payment_completed_at->format('Y-m-d H:i:s') : 'N/A',
                    $request->admin_notes ?? 'N/A',
                    $request->transaction_id ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
