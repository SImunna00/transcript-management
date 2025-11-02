<?php

namespace App\Http\Controllers;

use App\Models\Term;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getTerms($yearId)
    {
        Log::info("getTerms called with yearId: {$yearId}");

        try {
            // Since terms are already loaded in the blade view,
            // this method doesn't need to do anything anymore
            return response()->json([]);
        } catch (\Exception $e) {
            Log::error("Error in getTerms: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCourses($yearId, $termId)
    {
        Log::info("Fetching courses for academic_year_id: {$yearId} and term_id: {$termId}");

        try {
            // Force parameters to be integers
            $yearId = (int) $yearId;
            $termId = (int) $termId;

            // Validate parameters
            if (!$yearId || !$termId) {
                Log::error("Invalid parameters: yearId={$yearId}, termId={$termId}");
                return response()->json(['error' => 'Invalid year or term ID'], 400);
            }

            // Get courses using Eloquent
            $courses = Course::where('academic_year_id', $yearId)
                ->where('term_id', $termId)
                ->select('id', 'code', 'name')
                ->get();

            Log::info("Found " . count($courses) . " courses for year {$yearId} and term {$termId}");

            return response()->json($courses);
        } catch (\Exception $e) {
            Log::error("Error in getCourses: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getStudents($courseId, $yearId, $termId)
    {
        Log::info("Fetching students for course_id: {$courseId}, academic_year_id: {$yearId}, term_id: {$termId}");

        try {
            // Force parameters to be integers
            $courseId = (int) $courseId;
            $yearId = (int) $yearId;
            $termId = (int) $termId;

            Log::info("Converted parameters - courseId: {$courseId}, yearId: {$yearId}, termId: {$termId}");

            // Get the course to determine its academic year for session filtering
            $course = Course::find($courseId);
            Log::info("Course found: " . ($course ? $course->name : 'not found'));

            // First, get total count of students with studentid
            $totalStudents = User::whereNotNull('studentid')->count();
            Log::info("Total students with studentid: {$totalStudents}");

            // Build query to get students
            $query = User::select('id', 'name', 'studentid as student_id', 'session', 'academic_year_id', 'term_id')
                ->whereNotNull('studentid'); // Only get users with student IDs

            // Filter by academic year and term if students have these fields populated
            // Otherwise, we'll get all students and filter by session
            if ($yearId > 0) {
                // First try to get students with matching academic_year_id
                $studentsWithYear = User::select('id', 'name', 'studentid as student_id', 'session', 'academic_year_id', 'term_id')
                    ->whereNotNull('studentid')
                    ->where('academic_year_id', $yearId)
                    ->get();

                Log::info("Students with academic_year_id {$yearId}: " . count($studentsWithYear));

                if ($studentsWithYear->count() > 0) {
                    // If we have students with academic year, use them
                    $students = $studentsWithYear;

                    // Further filter by term if available
                    if ($termId > 0) {
                        $studentsWithTerm = $students->where('term_id', $termId);
                        Log::info("Students with term_id {$termId}: " . count($studentsWithTerm));
                        if ($studentsWithTerm->count() > 0) {
                            $students = $studentsWithTerm;
                        }
                    }
                } else {
                    // Fallback: get all students (they might not have year/term assigned yet)
                    Log::info("No students found with academic_year_id {$yearId}, getting all students");
                    $students = $query->orderBy('studentid', 'asc')->get();
                }
            } else {
                // No year specified, get all students
                Log::info("No year specified, getting all students");
                $students = $query->orderBy('studentid', 'asc')->get();
            }

            Log::info("Final student count: " . count($students));

            // Return students with proper structure and debug info
            $studentsArray = $students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'student_id' => $student->student_id,
                    'session' => $student->session ?? '2023-2024',
                    'academic_year_id' => $student->academic_year_id,
                    'term_id' => $student->term_id
                ];
            })->values(); // Convert to proper array with numeric indices

            return response()->json($studentsArray);
        } catch (\Exception $e) {
            Log::error("Error in getStudents: " . $e->getMessage());
            Log::error("Stack trace: " . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function saveProgress(Request $request)
    {
        try {
            $request->validate([
                'course_id' => 'required|exists:courses,id',
                'academic_year_id' => 'required|exists:academic_years,id',
                'term_id' => 'required|exists:terms,id',
                'marks' => 'required|array',
            ]);

            $courseId = $request->input('course_id');
            $academicYearId = $request->input('academic_year_id');
            $termId = $request->input('term_id');
            $marks = $request->input('marks');
            $courseCode = $request->input('course_code', '');
            $courseType = $request->input('course_type', 'theory');

            // Determine course type if not provided
            if (!$courseType || $courseType === 'theory') {
                $courseType = 'theory';
                if ($courseCode && str_ends_with($courseCode, '00')) {
                    $courseType = 'special';
                } elseif ($courseCode && (strpos($courseCode, 'Lab') !== false || strpos($courseCode, 'lab') !== false)) {
                    $courseType = 'lab';
                }
            }

            $totalSaved = 0;
            $errors = [];

            foreach ($marks as $studentId => $studentMarks) {
                try {
                    // Extract mark values
                    $attendance = $studentMarks['attendance'] ?? 0;
                    $ct = $studentMarks['ct'] ?? 0;
                    $semester = $studentMarks['semester'] ?? 0;
                    $report = $studentMarks['report'] ?? 0;
                    $labWork = $studentMarks['labWork'] ?? 0;
                    $viva = $studentMarks['viva'] ?? 0;
                    $total = $studentMarks['total'] ?? 0;
                    $session = $studentMarks['session'] ?? '2023-2024';

                    // Calculate grade and grade point
                    if ($courseType === 'theory') {
                        $calculatedTotal = $attendance + $ct + $semester;
                        list($grade, $gradePoint) = $this->calculateGradeAndPoint($calculatedTotal);

                        \App\Models\TheoryMark::updateOrCreate(
                            ['user_id' => $studentId, 'course_id' => $courseId],
                            [
                                'session' => $session,
                                'academic_year_id' => $academicYearId,
                                'term_id' => $termId,
                                'participation' => $attendance,
                                'ct' => $ct,
                                'semester_final' => $semester,
                                'total' => $calculatedTotal,
                                'grade' => $grade,
                                'grade_point' => $gradePoint,
                            ]
                        );
                    } elseif ($courseType === 'lab') {
                        $calculatedTotal = $attendance + $report + $labWork + $viva;
                        list($grade, $gradePoint) = $this->calculateGradeAndPoint($calculatedTotal);

                        \App\Models\LabMark::updateOrCreate(
                            ['user_id' => $studentId, 'course_id' => $courseId],
                            [
                                'session' => $session,
                                'academic_year_id' => $academicYearId,
                                'term_id' => $termId,
                                'attendance' => $attendance,
                                'report' => $report,
                                'lab_work' => $labWork,
                                'viva' => $viva,
                                'total' => $calculatedTotal,
                                'grade' => $grade,
                                'grade_point' => $gradePoint,
                            ]
                        );
                    } else { // special
                        list($grade, $gradePoint) = $this->calculateGradeAndPoint($total);

                        \App\Models\SpecialMark::updateOrCreate(
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
                    $errors[] = "Error saving marks for student ID {$studentId}: " . $e->getMessage();
                    Log::error("Error saving marks for student {$studentId}: " . $e->getMessage());
                }
            }

            $message = $totalSaved > 0
                ? "{$totalSaved} marks saved successfully."
                : "No marks were saved.";

            if (!empty($errors)) {
                $message .= " " . count($errors) . " errors occurred.";
                Log::error("Errors during save: " . json_encode($errors));
            }

            return response()->json([
                'message' => $message,
                'status' => $totalSaved > 0 ? 'success' : 'error',
                'saved' => $totalSaved,
                'errors' => $errors
            ]);

        } catch (\Exception $e) {
            Log::error("Error in saveProgress: " . $e->getMessage());
            return response()->json([
                'message' => 'Error saving marks: ' . $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }

    /**
     * Calculate grade and grade point based on total marks
     * Same logic as TeacherController to ensure consistency
     */
    private function calculateGradeAndPoint($total)
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
}
