<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class TeacherController extends Controller
{
    /**
     * Display teacher dashboard with statistics
     */
    public function dashboard()
    {
        $teacher = Auth::guard('teacher')->user();

        $stats = [
            'total_courses' => $teacher->courses()->count(),
            'current_courses' => $teacher->courses()
                ->wherePivot('academic_year', date('Y'))
                ->count(),
            'total_students' => User::whereHas('courses', function ($query) use ($teacher) {
                $query->whereIn('course_id', $teacher->courses()->pluck('courses.id'));
            })->count(),
            'pending_marks' => Result::where('submitted_by', $teacher->id)
                ->where('approved', false)
                ->count(),
        ];

        $recent_results = Result::with(['user', 'course'])
            ->where('submitted_by', $teacher->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('teacher.dashboard', compact('stats', 'recent_results'));
    }

    /**
     * Show teacher's assigned courses for specific year and term
     */
    public function courses(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        // Get available academic years and terms from the teacher's courses
        $academicYears = $teacher->courses()
            ->orderBy('academic_year', 'desc')
            ->pluck('academic_year')
            ->unique();

        $terms = $teacher->courses()
            ->orderBy('term', 'asc')
            ->pluck('term')
            ->unique();

        // Get selected year and term (default to the latest)
        $selectedYear = $request->input('year', $academicYears->first());
        $selectedTerm = $request->input('term', $terms->first());

        // Get assigned courses for the selected year and term
        $courses = $teacher->courses()
            ->wherePivot('academic_year', $selectedYear)
            ->wherePivot('term', $selectedTerm)
            ->withCount([
                'students' => function ($query) use ($selectedYear, $selectedTerm) {
                    $query->wherePivot('academic_year', $selectedYear)
                        ->wherePivot('term', $selectedTerm);
                }
            ])
            ->get();

        return view('teacher.courses', compact(
            'courses',
            'academicYears',
            'terms',
            'selectedYear',
            'selectedTerm'
        ));
    }

    /**
     * Show students enrolled in a specific course
     */
    public function courseStudents(Request $request, $courseId)
    {
        $teacher = Auth::guard('teacher')->user();

        // Validate that the teacher is assigned to this course
        $course = $teacher->courses()->findOrFail($courseId);

        // Get the academic year and term from the pivot table
        $academicYear = $request->input('year');
        $term = $request->input('term');

        // Get enrolled students with their result status
        $students = $course->students()
            ->wherePivot('academic_year', $academicYear)
            ->wherePivot('term', $term)
            ->withCount([
                'results' => function ($query) use ($courseId, $academicYear, $term) {
                    $query->where('course_id', $courseId)
                        ->where('academic_year', $academicYear)
                        ->where('term', $term);
                }
            ])
            ->get()
            ->map(function ($student) use ($courseId, $academicYear, $term) {
                $result = $student->results()
                    ->where('course_id', $courseId)
                    ->where('academic_year', $academicYear)
                    ->where('term', $term)
                    ->first();

                $student->has_result = (bool) $result;
                $student->result = $result;
                return $student;
            });

        return view('teacher.course-students', compact(
            'course',
            'students',
            'academicYear',
            'term'
        ));
    }

    /**
     * Show form to input marks for a student
     */
    public function createMarkEntry($courseId, $studentId, Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        // Validate teacher is assigned to this course
        $course = $teacher->courses()->findOrFail($courseId);

        // Get the student
        $student = User::findOrFail($studentId);

        // Get academic year and term
        $academicYear = $request->input('year');
        $term = $request->input('term');

        // Check if result already exists
        $result = Result::where('user_id', $studentId)
            ->where('course_id', $courseId)
            ->where('academic_year', $academicYear)
            ->where('term', $term)
            ->first();

        return view('teacher.mark-entry', compact(
            'course',
            'student',
            'academicYear',
            'term',
            'result'
        ));
    }

    /**
     * Store marks for a student
     */
    public function storeMarkEntry(Request $request, $courseId, $studentId)
    {
        $teacher = Auth::guard('teacher')->user();

        // Validate teacher is assigned to this course
        $course = $teacher->courses()->findOrFail($courseId);
        $student = User::findOrFail($studentId);

        // Validate the input
        $validated = $request->validate([
            'attendance' => 'required|numeric|min:0|max:10',
            'class_test' => 'required|numeric|min:0|max:15',
            'mid_term' => 'required|numeric|min:0|max:25',
            'final' => 'required|numeric|min:0|max:40',
            'viva' => 'required|numeric|min:0|max:10',
            'academic_year' => 'required|string',
            'term' => 'required|string',
        ]);

        // Find or create result
        $result = Result::firstOrNew([
            'user_id' => $studentId,
            'course_id' => $courseId,
            'academic_year' => $validated['academic_year'],
            'term' => $validated['term'],
        ]);

        // Fill in the marks
        $result->fill([
            'attendance' => $validated['attendance'],
            'class_test' => $validated['class_test'],
            'mid_term' => $validated['mid_term'],
            'final' => $validated['final'],
            'viva' => $validated['viva'],
            'submitted_by' => $teacher->id,
        ]);

        // Calculate grade and grade point
        $result->calculateGrade();

        // Generate PDF and save
        $pdf = $this->generateResultPDF($result);

        // Save PDF to storage
        $filePath = 'results/' . $result->academic_year . '/' . $result->term . '/';
        $fileName = 'result_' . $student->studentid . '_' . $course->course_code . '.pdf';

        Storage::disk('public')->put($filePath . $fileName, $pdf->output());

        // Update result with file path
        $result->result_file = 'public/' . $filePath . $fileName;
        $result->save();

        return redirect()->route('teacher.courseStudents', [
            'course' => $courseId,
            'year' => $validated['academic_year'],
            'term' => $validated['term'],
        ])->with('success', 'Marks entered successfully for ' . $student->name);
    }

    /**
     * Generate result PDF for a student
     */
    private function generateResultPDF(Result $result)
    {
        $student = $result->user;
        $course = $result->course;
        $teacher = $result->teacher;

        // Get all results for the student in the same term/year
        $allResults = Result::with('course')
            ->where('user_id', $student->id)
            ->where('academic_year', $result->academic_year)
            ->where('term', $result->term)
            ->get();

        // Calculate TGPA (Term Grade Point Average)
        $totalCredits = $allResults->sum(function ($result) {
            return $result->course->credits;
        });

        $weightedGP = $allResults->sum(function ($result) {
            return $result->grade_point * $result->course->credits;
        });

        $tgpa = $totalCredits > 0 ? $weightedGP / $totalCredits : 0;

        // Generate PDF
        $data = [
            'student' => $student,
            'course' => $course,
            'result' => $result,
            'teacher' => $teacher,
            'allResults' => $allResults,
            'tgpa' => $tgpa,
            'totalCredits' => $totalCredits,
            'print_date' => now()->format('F d, Y'),
        ];

        return PDF::loadView('pdf.result', $data);
    }

    /**
     * View all results submitted by the teacher
     */
    public function viewAllResults(Request $request)
    {
        $teacher = Auth::guard('teacher')->user();

        $query = Result::with(['user', 'course'])
            ->where('submitted_by', $teacher->id);

        // Apply filters if provided
        if ($request->filled('year')) {
            $query->where('academic_year', $request->year);
        }

        if ($request->filled('term')) {
            $query->where('term', $request->term);
        }

        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        if ($request->filled('status')) {
            $query->where('approved', $request->status === 'approved');
        }

        $results = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $academicYears = Result::where('submitted_by', $teacher->id)
            ->select('academic_year')
            ->distinct()
            ->pluck('academic_year');

        $terms = Result::where('submitted_by', $teacher->id)
            ->select('term')
            ->distinct()
            ->pluck('term');

        $courses = Course::whereHas('results', function ($query) use ($teacher) {
            $query->where('submitted_by', $teacher->id);
        })->get();

        return view('teacher.all-results', compact(
            'results',
            'academicYears',
            'terms',
            'courses'
        ));
    }

    /**
     * Preview generated PDF
     */
    public function previewResultPDF($resultId)
    {
        $teacher = Auth::guard('teacher')->user();

        $result = Result::where('id', $resultId)
            ->where('submitted_by', $teacher->id)
            ->firstOrFail();

        if (!$result->result_file || !Storage::exists($result->result_file)) {
            abort(404, 'Result PDF not found');
        }

        return response()->file(Storage::path($result->result_file));
    }
}
