<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Department;
use App\Models\Semester;
use App\Models\TheoryMark;
use App\Models\LabMark;
use App\Models\SpecialMark;
use App\Models\SemesterResult;
use App\Models\Transcript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AcademicYear;
use App\Models\Term;
class MarkEntryController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::all();
        $terms = Term::all();

        // Load all courses with their academic year and term info
        $allCourses = Course::with(['academicYear', 'term'])
            ->select('id', 'code', 'name', 'academic_year_id', 'term_id')
            ->get();

        return view('teacher.marks-entry-system', compact('academicYears', 'terms', 'allCourses'));
    }

    public function getSemesters(Request $request)
    {
        $department_id = $request->department_id;
        $semesters = Semester::where('department_id', $department_id)->get();

        return response()->json($semesters);
    }

    public function getCourses(Request $request)
    {
        $semester_id = $request->semester_id;
        $teacher_id = Auth::guard('teacher')->id();

        // Get courses that belong to this semester and are assigned to the current teacher
        $courses = Course::where('semester_id', $semester_id)
            ->whereHas('teachers', function ($query) use ($teacher_id) {
                $query->where('teachers.id', $teacher_id);
            })
            ->get();

        return response()->json($courses);
    }

    public function getStudents(Request $request)
    {
        $session = $request->session;
        $course_id = $request->input('course_id');
        $academic_year = $request->input('academic_year');
        $term = $request->input('term');

        if ($course_id) {
            // Get students enrolled in this specific course
            $students = User::whereHas('courses', function ($query) use ($course_id, $academic_year, $term) {
                $query->where('courses.id', $course_id);
                if ($academic_year) {
                    $query->where('course_enrollments.academic_year', $academic_year);
                }
                if ($term) {
                    $query->where('course_enrollments.term', $term);
                }
            })->get();
        } else {
            // Fallback to just filtering by session
            $students = User::where('session', $session)->get();
        }

        return response()->json($students);
    }

    public function saveMarks(Request $request)
    {
        $course_id = $request->course_id;
        $course = Course::findOrFail($course_id);
        $course_type = $course->course_type;

        $students = $request->students;

        foreach ($students as $student) {
            $student_id = $student['student_id'];
            $session = $student['session'];
            $semester_id = $course->semester_id;

            if ($course_type === 'theory') {
                TheoryMark::updateOrCreate(
                    ['student_id' => $student_id, 'course_id' => $course_id, 'semester_id' => $semester_id, 'session' => $session],
                    [
                        'participation' => $student['participation'],
                        'ct' => $student['ct'],
                        'semester_final' => $student['semester_final'],
                        'total' => $student['total'],
                        'grade' => $student['grade'],
                        'grade_point' => $student['grade_point']
                    ]
                );
            } elseif ($course_type === 'lab') {
                LabMark::updateOrCreate(
                    ['student_id' => $student_id, 'course_id' => $course_id, 'semester_id' => $semester_id, 'session' => $session],
                    [
                        'report' => $student['report'],
                        'lab_work' => $student['lab_work'],
                        'attendance' => $student['attendance'],
                        'viva' => $student['viva'],
                        'total' => $student['total'],
                        'grade' => $student['grade'],
                        'grade_point' => $student['grade_point']
                    ]
                );
            } elseif ($course_type === 'special') {
                SpecialMark::updateOrCreate(
                    ['student_id' => $student_id, 'course_id' => $course_id, 'semester_id' => $semester_id, 'session' => $session],
                    [
                        'full_marks' => $student['full_marks'],
                        'grade' => $student['grade'],
                        'grade_point' => $student['grade_point']
                    ]
                );
            }
        }

        return response()->json(['success' => true, 'message' => 'Marks saved successfully']);
    }

    public function calculateSemesterResult(Request $request)
    {
        $student_id = $request->student_id;
        $semester_id = $request->semester_id;
        $session = $request->session;

        // Get all courses for this semester
        $courses = Course::where('semester_id', $semester_id)->get();

        $total_credits = 0;
        $total_grade_points = 0;

        foreach ($courses as $course) {
            $grade_point = 0;

            if ($course->course_type === 'theory') {
                $mark = TheoryMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
                if ($mark) {
                    $grade_point = $mark->grade_point;
                }
            } elseif ($course->course_type === 'lab') {
                $mark = LabMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
                if ($mark) {
                    $grade_point = $mark->grade_point;
                }
            } elseif ($course->course_type === 'special') {
                $mark = SpecialMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
                if ($mark) {
                    $grade_point = $mark->grade_point;
                }
            }

            $total_credits += $course->credits;
            $total_grade_points += ($grade_point * $course->credits);
        }

        // Calculate Term GPA (TGPA)
        $gpa = $total_credits > 0 ? round($total_grade_points / $total_credits, 2) : 0;

        // Save semester result
        SemesterResult::updateOrCreate(
            ['student_id' => $student_id, 'semester_id' => $semester_id, 'session' => $session],
            [
                'total_credits' => $total_credits,
                'gpa' => $gpa
            ]
        );

        // Calculate CGPA
        $this->calculateCGPA($student_id);

        return response()->json([
            'success' => true,
            'gpa' => $gpa,
            'total_credits' => $total_credits
        ]);
    }

    /**
     * Calculate CGPA for a student based on all their semester results.
     *
     * CGPA = sum(TGPA × credits of term) / sum(total credits of completed terms)
     */
    protected function calculateCGPA($student_id)
    {
        $semesterResults = SemesterResult::where('student_id', $student_id)->get();

        $total_credits_completed = 0;
        $total_weighted_gpa = 0;

        foreach ($semesterResults as $result) {
            // For each semester, multiply TGPA by the credits for that term
            $total_weighted_gpa += ($result->gpa * $result->total_credits);
            $total_credits_completed += $result->total_credits;
        }

        // Calculate CGPA
        $cgpa = $total_credits_completed > 0 ? round($total_weighted_gpa / $total_credits_completed, 2) : 0;

        // Update or create transcript record with CGPA
        Transcript::updateOrCreate(
            ['user_id' => $student_id],
            [
                'cgpa' => $cgpa,
                'total_credits_completed' => $total_credits_completed,
                'status' => 'processing'
            ]
        );

        return $cgpa;
    }

    /**
     * Show the marksheet generation form.
     */
    public function marksheetForm()
    {
        // No need for departments since we're only using ICE department
        $academicYears = ['2021-2022', '2022-2023', '2023-2024', '2024-2025', '2025-2026'];

        return view('teacher.marksheet', compact('academicYears'));
    }

    public function generateMarksheet(Request $request)
    {
        $student_id = $request->student_id;
        $semester_id = $request->semester_id;
        $session = $request->session;

        $student = User::findOrFail($student_id);
        $semester = Semester::findOrFail($semester_id);

        // Using hardcoded ICE department (assuming id is 1)
        $department = Department::find(1);

        // If no ICE department is found, create it
        if (!$department) {
            $department = Department::create([
                'name' => 'Information and Communication Engineering',
                'code' => 'ICE',
                'description' => 'Department of Information and Communication Engineering',
                'total_semesters' => 8
            ]);
        }

        $courses = Course::where('semester_id', $semester_id)->get();

        $marks = [];

        foreach ($courses as $course) {
            $mark = null;

            if ($course->course_type === 'theory') {
                $mark = TheoryMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
            } elseif ($course->course_type === 'lab') {
                $mark = LabMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
            } elseif ($course->course_type === 'special') {
                $mark = SpecialMark::where('student_id', $student_id)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->first();
            }

            if ($mark) {
                $marks[] = [
                    'course' => $course,
                    'mark' => $mark
                ];
            }
        }

        $semesterResult = SemesterResult::where('student_id', $student_id)
            ->where('semester_id', $semester_id)
            ->where('session', $session)
            ->first();

        // Get transcript with CGPA
        $transcript = Transcript::where('user_id', $student_id)->first();

        // If transcript doesn't exist, calculate CGPA
        if (!$transcript) {
            $cgpa = $this->calculateCGPA($student_id);
            $transcript = Transcript::where('user_id', $student_id)->first();
        }

        $data = [
            'student' => $student,
            'department' => $department,
            'semester' => $semester,
            'session' => $session,
            'marks' => $marks,
            'semesterResult' => $semesterResult,
            'transcript' => $transcript
        ];

        $pdf = PDF::loadView('pdf.marksheet', $data);

        return $pdf->stream('marksheet.pdf');
    }

    /**
     * View CGPA for a specific student.
     *
     * @param int $student_id
     * @return \Illuminate\View\View
     */
    public function viewCGPA($student_id)
    {
        $student = User::findOrFail($student_id);
        $transcript = Transcript::where('user_id', $student_id)->first();

        if (!$transcript) {
            // Calculate CGPA if transcript doesn't exist
            $this->calculateCGPA($student_id);
            $transcript = Transcript::where('user_id', $student_id)->first();
        }

        // Get all semester results for the student
        $semesterResults = SemesterResult::where('student_id', $student_id)
            ->with('semester')
            ->orderBy('semester_id')
            ->get();

        return view('teacher.view-cgpa', compact('student', 'transcript', 'semesterResults'));
    }
}
