<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Semester;
use App\Models\TheoryMark;
use App\Models\LabMark;
use App\Models\SpecialMark;

class TeacherController extends Controller
{
    /**
     * Display teacher dashboard with statistics
     */
    public function dashboard()
    {
        // Use dummy data
        $stats = [
            "total_courses" => 5,
            "current_courses" => 3,
            "total_students" => 120,
            "pending_marks" => 15,
        ];

        $recent_results = [];

        return view("teacher.dashboard", compact("stats", "recent_results"));
    }

    /**
     * Show teacher"s assigned courses for specific year and term
     */

    /**
     * Store marks for a student
     */

    public function storeMarkEntry(Request $request)
    {
        // Get the form data
        $courseId = $request->input('course_id');
        $academicYearId = $request->input('academic_year_id');
        $termId = $request->input('term_id');
        $courseType = $request->input('course_type', 'theory');

        // Get student IDs array
        $studentIds = $request->input('student_ids', []);

        // Debug: Log the received data
        \Log::info('Mark Entry Debug:', [
            'course_id' => $courseId,
            'academic_year_id' => $academicYearId,
            'term_id' => $termId,
            'course_type' => $courseType,
            'student_ids' => $studentIds,
            'request_data' => $request->all()
        ]);

        $totalSaved = 0;
        $errors = [];

        // Process each student's marks
        foreach ($studentIds as $studentId) {
            try {
                // Get the student's session
                $student = User::find($studentId);
                if (!$student) {
                    $errors[] = "Student with ID {$studentId} not found.";
                    continue;
                }
                $session = $student->session ?? '2023-2024';

                if ($courseType === 'theory') {
                    $attendance = $request->input("attendance.{$studentId}", 0);
                    $ct = $request->input("ct_marks.{$studentId}", 0);
                    $semester = $request->input("semester.{$studentId}", 0);
                    $total = $attendance + $ct + $semester;

                    \Log::info("Theory marks for student {$studentId}:", [
                        'attendance' => $attendance,
                        'ct' => $ct,
                        'semester' => $semester,
                        'total' => $total
                    ]);

                    list($grade, $gradePoint) = $this->calculateGradeAndPoint($total);

                    TheoryMark::updateOrCreate(
                        ['user_id' => $studentId, 'course_id' => $courseId],
                        [
                            'session' => $session,
                            'academic_year_id' => $academicYearId,
                            'term_id' => $termId,
                            'participation' => $attendance,
                            'ct' => $ct,
                            'semester_final' => $semester,
                            'total' => $total,
                            'grade' => $grade,
                            'grade_point' => $gradePoint,
                        ]
                    );
                } elseif ($courseType === 'lab') {
                    $attendance = $request->input("attendance.{$studentId}", 0);
                    $report = $request->input("report.{$studentId}", 0);
                    $labWork = $request->input("lab_work.{$studentId}", 0);
                    $viva = $request->input("viva.{$studentId}", 0);
                    $total = $attendance + $report + $labWork + $viva;

                    list($grade, $gradePoint) = $this->calculateGradeAndPoint($total);

                    LabMark::updateOrCreate(
                        ['user_id' => $studentId, 'course_id' => $courseId],
                        [
                            'session' => $session,
                            'academic_year_id' => $academicYearId,
                            'term_id' => $termId,
                            'attendance' => $attendance,
                            'report' => $report,
                            'lab_work' => $labWork,
                            'viva' => $viva,
                            'total' => $total,
                            'grade' => $grade,
                            'grade_point' => $gradePoint,
                        ]
                    );
                } else { // special
                    $total = $request->input("total_mark.{$studentId}", 0);

                    list($grade, $gradePoint) = $this->calculateGradeAndPoint($total);

                    SpecialMark::updateOrCreate(
                        ['user_id' => $studentId, 'course_id' => $courseId],
                        [
                            'session' => $session,
                            'academic_year_id' => $academicYearId,
                            'term_id' => $termId,
                            'full_marks' => $total,
                            'grade' => $grade,
                            'grade_point' => $gradePoint,
                        ]
                    );
                }

                $totalSaved++;
            } catch (\Exception $e) {
                $errorMsg = "Error processing student ID {$studentId}: " . $e->getMessage();
                $errors[] = $errorMsg;
                \Log::error($errorMsg, ['exception' => $e]);
            }
        }

        $message = $totalSaved > 0
            ? "{$totalSaved} student marks saved successfully."
            : "No marks were saved.";

        if (!empty($errors)) {
            $message .= " There were " . count($errors) . " errors.";
            \Log::error('Mark Entry Errors:', $errors);
        }

        $status = $totalSaved > 0 ? 'success' : 'error';

        return redirect()->back()->with($status, $message);
    }


    public function calculateGradeAndPoint($total)
    {
        if ($total >= 80)
            return ['A+', 4.00];
        if ($total >= 75)
            return ['A', 3.75];
        if ($total >= 70)
            return ['A-', 3.50];
        if ($total >= 65)
            return ['B+', 3.25];
        if ($total >= 60)
            return ['B', 3.00];
        if ($total >= 55)
            return ['B-', 2.75];
        if ($total >= 50)
            return ['C+', 2.50];
        if ($total >= 45)
            return ['C', 2.00];
        if ($total >= 40)
            return ['D', 1.00];
        return ['F', 0.00];
    }

    /**
     * View all results submitted by the teacher
     */
    public function viewAllResults(Request $request)
    {
        // Just return an empty view with dummy data
        $results = collect([]);
        $academicYears = collect(["2024", "2025"]);
        $terms = collect(["Fall", "Spring", "Summer"]);
        $courses = collect([]);

        return view("teacher.all-results", compact(
            "results",
            "academicYears",
            "terms",
            "courses"
        ));
    }

    /**
     * Preview generated PDF
     */
    public function previewResultPDF($resultId)
    {
        // Just return a response with a dummy message
        return response("PDF preview not available in demo mode.", 200);
    }

    /**
     * Display mark entry form
     */
    public function markEntryForm()
    {
        $sessions = ['2023-2024', '2024-2025', '2025-2026']; // Adjust based on your needs
        return view('teacher.mark-entry-form', compact('sessions'));
    }

    /**
     * Search for student by ID or name
     */
    public function searchStudent(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
            'session' => 'required|string'
        ]);

        $search = $request->input('search');
        $session = $request->input('session');

        // Search by student ID or name
        $students = User::where('session', $session)
            ->where(function ($query) use ($search) {
                $query->where('studentid', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->get();

        return view('teacher.student-search-results', compact('students', 'session', 'search'));
    }

    /**
     * Display student marks form
     */
    public function studentMarks(User $student)
    {
        // Get courses for which the teacher can enter marks
        $courses = Course::all(); // In a real app, filter by teacher's department

        // Get existing marks for this student
        $theoryMarks = $student->theoryMarks;
        $labMarks = $student->labMarks;

        return view('teacher.student-marks', compact('student', 'courses', 'theoryMarks', 'labMarks'));
    }

    /**
     * Save student marks
     */
    public function saveMarks(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required',
            'session' => 'required|string',
            'marks' => 'required|array',
            'marks.theory.*' => 'nullable|numeric|min:0|max:100',
            'marks.lab.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $studentId = $request->input('student_id');
        $courseId = $request->input('course_id');
        $session = $request->input('session');
        $marks = $request->input('marks');

        // Instead of querying the database for the course, use the course_type from the form
        $courseType = $request->input('course_type', 'theory');

        // Process theory marks
        if (isset($marks['theory'])) {
            $theoryMark = \App\Models\TheoryMark::updateOrCreate(
                [
                    'user_id' => $studentId,
                    'course_id' => $courseId,
                    'academic_year' => $request->input('academic_year', date('Y')),
                    'term' => $request->input('term', 'Fall'),
                ],
                [
                    'class_test' => $marks['theory']['class_test'] ?? 0,
                    'attendance' => $marks['theory']['attendance'] ?? 0,
                    'final_exam' => $marks['theory']['final_exam'] ?? 0,
                    'total' => array_sum($marks['theory']),
                    // Grade calculation would happen here in a real app
                ]
            );
        }

        // Process lab marks
        if (isset($marks['lab'])) {
            $labMark = \App\Models\LabMark::updateOrCreate(
                [
                    'user_id' => $studentId,
                    'course_id' => $courseId,
                    'academic_year' => $request->input('academic_year', date('Y')),
                    'term' => $request->input('term', 'Fall'),
                ],
                [
                    'lab_performance' => $marks['lab']['lab_performance'] ?? 0,
                    'lab_report' => $marks['lab']['lab_report'] ?? 0,
                    'lab_final' => $marks['lab']['lab_final'] ?? 0,
                    'total' => array_sum($marks['lab']),
                    // Grade calculation would happen here in a real app
                ]
            );
        }

        return redirect()->route('teacher.mark.student', $studentId)
            ->with('success', 'Marks saved successfully');
    }
}
