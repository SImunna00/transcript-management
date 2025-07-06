<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;

class ResultApprovalController extends Controller
{
    /**
     * Display pending results for approval
     */
    public function index(Request $request)
    {
        $query = Result::with(['user', 'course', 'teacher'])
            ->where('approved', false)
            ->orderBy('created_at', 'desc');

        // Apply filters if provided
        if ($request->filled('teacher')) {
            $query->where('submitted_by', $request->teacher);
        }

        if ($request->filled('year')) {
            $query->where('academic_year', $request->year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        $results = $query->paginate(20);

        // Get filter options
        $teachers = \App\Models\Teacher::whereHas('courses')->get();
        $academicYears = Result::select('academic_year')->distinct()->pluck('academic_year');
        $terms = Result::select('term')->distinct()->pluck('term');
        $courses = \App\Models\Course::whereHas('results')->get();

        return view('admin.results.pending', compact(
            'results',
            'teachers',
            'academicYears',
            'terms',
            'courses'
        ));
    }

    /**
     * Display all approved results
     */
    public function approved(Request $request)
    {
        $query = Result::with(['user', 'course', 'teacher'])
            ->where('approved', true)
            ->orderBy('approved_at', 'desc');

        // Apply filters if provided
        if ($request->filled('teacher')) {
            $query->where('submitted_by', $request->teacher);
        }

        if ($request->filled('year')) {
            $query->where('academic_year', $request->year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        $results = $query->paginate(20);

        // Get filter options
        $teachers = \App\Models\Teacher::whereHas('courses')->get();
        $academicYears = Result::select('academic_year')->distinct()->pluck('academic_year');
        $terms = Result::select('term')->distinct()->pluck('term');
        $courses = \App\Models\Course::whereHas('results')->get();

        return view('admin.results.approved', compact(
            'results',
            'teachers',
            'academicYears',
            'terms',
            'courses'
        ));
    }

    /**
     * Preview result PDF
     */
    public function previewResult($id)
    {
        $result = Result::findOrFail($id);

        if (!$result->result_file || !\Storage::exists($result->result_file)) {
            abort(404, 'Result PDF not found');
        }

        return response()->file(\Storage::path($result->result_file));
    }

    /**
     * Approve a result
     */
    public function approve($id)
    {
        $result = Result::findOrFail($id);

        // Check if the result is already approved
        if ($result->approved) {
            return back()->with('error', 'This result is already approved.');
        }

        // Update result with approval information
        $result->update([
            'approved' => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('success', 'Result has been approved successfully.');
    }

    /**
     * Bulk approve results
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'result_ids' => 'required|array',
            'result_ids.*' => 'exists:results,id',
        ]);

        $count = Result::whereIn('id', $request->result_ids)
            ->where('approved', false)
            ->update([
                'approved' => true,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

        return back()->with('success', $count . ' results have been approved successfully.');
    }
}
