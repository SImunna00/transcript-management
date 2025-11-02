<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Marksheet;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\Term;
use App\Models\Course;
use App\Models\TheoryMark;
use App\Models\LabMark;
use App\Models\SpecialMark;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MarksheetController extends Controller
{
    public function index(Request $request)
    {
        // Base query
        $query = Marksheet::with(['student', 'user', 'academicYear', 'term', 'generatedBy']);

        // Handle search
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('student', function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('studentid', 'like', "%{$searchTerm}%");
            });
        }

        // Handle filters
        if ($request->filled('session')) {
            $query->where('session', $request->session);
        }
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        if ($request->filled('term_id')) {
            $query->where('term_id', $request->term_id);
        }

        // Statistics calculated on the filtered query *before* pagination
        $stats = [
            'total_generated' => $query->count(),
            'draft_marksheets' => $query->clone()->where('status', 'draft')->count(),
            'published_marksheets' => $query->clone()->where('status', 'published')->count(),
        ];

        // Paginate the results
        $marksheets = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        // Data for filter dropdowns
        $startYear = 2008;
        $endYear = 2027;
        $sessions = collect();
        for ($year = $startYear; $year <= $endYear; $year++) {
            $sessions->push($year . '-' . ($year + 1));
        }
        $academic_years = AcademicYear::all();
        $terms = Term::all();

        return view('admin.marksheets.index', compact('marksheets', 'stats', 'sessions', 'academic_years', 'terms'));
    }

    public function create()
    {
        $students = User::with(['academicYear', 'term'])->whereNotNull('studentid')->get();
        $startYear = 2007;
        $endYear = 2029;
        $sessions = collect();
        for ($year = $startYear; $year <= $endYear; $year++) {
            $sessions->push($year . '-' . ($year + 1));
        }
        $academicYears = AcademicYear::all();
        $terms = Term::all();

        return view('admin.marksheets.create', compact('students', 'sessions', 'academicYears', 'terms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session' => 'required|string',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term_id' => 'required|exists:terms,id'
        ]);

        $userId = $request->user_id;
        $session = $request->session;
        $academicYearId = $request->academic_year_id;
        $termId = $request->term_id;

        // Check if any marks exist for this student, session, academic year, and term
        $marksExist = $this->checkMarksExist($userId, $session, $academicYearId, $termId);

        if (!$marksExist) {
            return redirect()->back()
                ->withErrors(['error' => 'No marks found for this student in the specified session, year, and term.']);
        }

        // Calculate TGPA and CGPA
        $calculations = $this->calculateGPA($userId, $session, $academicYearId, $termId);

        // Create or update marksheet record
        $marksheet = Marksheet::updateOrCreate(
            [
                'user_id' => $userId,
                'session' => $session,
                'academic_year_id' => $academicYearId,
                'term_id' => $termId
            ],
            array_merge($calculations, [
                'generated_at' => now(),
                'generated_by' => auth()->id(),
                'status' => 'approved'
            ])
        );

        // Generate and save PDF
        $this->generateAndSavePDF($marksheet);

        return redirect()->route('admin.marksheets.show', $marksheet->id)
            ->with('success', 'Marksheet generated successfully!');
    }

    public function show($id)
    {
        $marksheet = Marksheet::with(['student', 'academicYear', 'term', 'generatedBy'])->findOrFail($id);
        $marks = $marksheet->getAllMarks();

        // Get other marksheets for this student
        $other_marksheets = Marksheet::with(['academicYear', 'term'])
            ->where('user_id', $marksheet->user_id)
            ->where('id', '!=', $id)
            ->orderBy('session', 'desc')
            ->orderBy('academic_year_id', 'desc')
            ->orderBy('term_id', 'desc')
            ->limit(5)
            ->get();

        return view('admin.marksheets.show', compact('marksheet', 'marks', 'other_marksheets'));
    }

    public function downloadPDF($id)
    {
        $marksheet = Marksheet::with(['student', 'academicYear', 'term'])->findOrFail($id);

        // Check if PDF file exists
        if ($marksheet->file_path && file_exists(storage_path('app/public/' . $marksheet->file_path))) {
            return response()->download(storage_path('app/public/' . $marksheet->file_path), $marksheet->pdf_filename);
        }

        // If file doesn't exist, regenerate it
        $this->generateAndSavePDF($marksheet);

        if ($marksheet->file_path && file_exists(storage_path('app/public/' . $marksheet->file_path))) {
            return response()->download(storage_path('app/public/' . $marksheet->file_path), $marksheet->pdf_filename);
        }

        // Fallback: generate PDF on-the-fly
        $marks = $marksheet->getAllMarks();
        $pdf = Pdf::loadView('admin.marksheets.pdf-template', compact('marksheet', 'marks'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        $filename = $marksheet->student->name . '_' . $marksheet->academicYear->name . 'Y_' . $marksheet->term->name . 'T_marksheet.pdf';
        return $pdf->download($filename);
    }

    public function generateTranscript($id)
    {
        $marksheet = Marksheet::with(['student', 'academicYear', 'term'])->findOrFail($id);
        $marks = $marksheet->getAllMarks();

        $pdf = Pdf::loadView('admin.marksheets.pdf-template', compact('marksheet', 'marks'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'defaultFont' => 'serif',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true
            ]);

        $filename = $marksheet->student->name . '_' . $marksheet->academicYear->name . 'Y_' . $marksheet->term->name . 'T_transcript.pdf';
        return $pdf->download($filename);
    }

    public function bulkGenerate(Request $request)
    {
        $request->validate([
            'session' => 'required|string',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term_id' => 'required|exists:terms,id',
            'user_ids' => 'array',
            'user_ids.*' => 'exists:users,id'
        ]);

        $session = $request->session;
        $academicYearId = $request->academic_year_id;
        $termId = $request->term_id;
        $userIds = $request->user_ids ?? [];

        // If no specific students selected, get all students with marks for this session/year/term
        if (empty($userIds)) {
            $userIds = $this->getStudentsWithMarks($session, $academicYearId, $termId);
        }

        $generated = 0;
        $errors = [];

        foreach ($userIds as $userId) {
            try {
                if ($this->checkMarksExist($userId, $session, $academicYearId, $termId)) {
                    $calculations = $this->calculateGPA($userId, $session, $academicYearId, $termId);

                    Marksheet::updateOrCreate(
                        [
                            'user_id' => $userId,
                            'session' => $session,
                            'academic_year_id' => $academicYearId,
                            'term_id' => $termId
                        ],
                        array_merge($calculations, [
                            'generated_at' => now(),
                            'generated_by' => auth()->id(),
                            'status' => 'approved'
                        ])
                    );
                    $generated++;
                }
            } catch (\Exception $e) {
                $student = User::find($userId);
                $errors[] = "Failed to generate marksheet for {$student->name}: " . $e->getMessage();
            }
        }

        $message = "Successfully generated {$generated} marksheets.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        return redirect()->route('admin.marksheets.index')->with('success', $message);
    }

    public function quickGenerate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session' => 'required|string',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term_id' => 'required|exists:terms,id'
        ]);

        $userId = $request->user_id;
        $session = $request->session;
        $academicYearId = $request->academic_year_id;
        $termId = $request->term_id;

        // Check if any marks exist for this student, session, academic year, and term
        $marksExist = $this->checkMarksExist($userId, $session, $academicYearId, $termId);

        if (!$marksExist) {
            return redirect()->back()
                ->withErrors(['error' => 'No marks found for this student in the specified session, year, and term.']);
        }

        // Calculate TGPA and CGPA
        $calculations = $this->calculateGPA($userId, $session, $academicYearId, $termId);

        // Create or update marksheet record
        $marksheet = Marksheet::updateOrCreate(
            [
                'user_id' => $userId,
                'session' => $session,
                'academic_year_id' => $academicYearId,
                'term_id' => $termId
            ],
            array_merge($calculations, [
                'generated_at' => now(),
                'generated_by' => auth()->id(),
                'status' => 'approved'
            ])
        );

        // Generate and save PDF
        $this->generateAndSavePDF($marksheet);

        return redirect()->route('admin.marksheets.show', $marksheet->id)
            ->with('success', 'Marksheet generated successfully!');
    }

    public function recalculate($id)
    {
        $marksheet = Marksheet::findOrFail($id);

        $calculations = $this->calculateGPA(
            $marksheet->user_id,
            $marksheet->session,
            $marksheet->academic_year_id,
            $marksheet->term_id
        );

        $marksheet->update(array_merge($calculations, [
            'generated_at' => now(),
            'generated_by' => auth()->id()
        ]));

        return redirect()->back()->with('success', 'Marksheet recalculated successfully!');
    }

    private function checkMarksExist($userId, $session, $academicYearId, $termId)
    {
        $theoryExists = TheoryMark::where('user_id', $userId)
            ->where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->exists();

        $labExists = LabMark::where('user_id', $userId)
            ->where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->exists();

        $specialExists = SpecialMark::where('user_id', $userId)
            ->where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->exists();

        return $theoryExists || $labExists || $specialExists;
    }

    private function getStudentsWithMarks($session, $academicYearId, $termId)
    {
        $theoryStudents = TheoryMark::where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->distinct()
            ->pluck('user_id');

        $labStudents = LabMark::where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->distinct()
            ->pluck('user_id');

        $specialStudents = SpecialMark::where('session', $session)
            ->where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->distinct()
            ->pluck('user_id');

        return $theoryStudents->merge($labStudents)->merge($specialStudents)->unique()->values()->toArray();
    }

    private function calculateGPA($userId, $session, $academicYearId, $termId)
    {
        // Get all courses for this academic year and term
        $courses = Course::where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->get();

        $totalGradePoints = 0;
        $totalCredits = 0;
        $creditsCompleted = 0;

        foreach ($courses as $course) {
            $gradePoint = 0.00;
            $credits = $course->credits;

            // Check theory marks
            $theoryMark = TheoryMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->first();

            // Check lab marks
            $labMark = LabMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->first();

            // Check special marks
            $specialMark = SpecialMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->first();

            // Use the highest grade point if multiple mark types exist for the same course
            if ($theoryMark) {
                $gradePoint = max($gradePoint, $theoryMark->grade_point);
            }
            if ($labMark) {
                $gradePoint = max($gradePoint, $labMark->grade_point);
            }
            if ($specialMark) {
                $gradePoint = max($gradePoint, $specialMark->grade_point);
            }

            // Always include the course in the calculation.
            // If no mark was found, $gradePoint is 0, correctly factoring it as a failure.
            $totalGradePoints += $gradePoint * $credits;
            $totalCredits += $credits;

            // Credits are only "completed" if the student passed (grade point > 0).
            if ($gradePoint > 0) {
                $creditsCompleted += $credits;
            }
        }

        $tgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

        // Calculate CGPA (all previous academic years and terms)
        $allCgpaPoints = 0;
        $allCgpaCredits = 0;
        $allCreditsCompleted = 0;

        // Get all academic years up to and including current
        $allAcademicYears = AcademicYear::where('id', '<=', $academicYearId)->orderBy('id')->get();

        foreach ($allAcademicYears as $year) {
            $termsToCheck = Term::orderBy('id')->get();
            if ($year->id == $academicYearId) {
                // For current academic year, only check up to current term
                $termsToCheck = Term::where('id', '<=', $termId)->orderBy('id')->get();
            }

            foreach ($termsToCheck as $term) {
                $yearCourses = Course::where('academic_year_id', $year->id)
                    ->where('term_id', $term->id)
                    ->get();

                foreach ($yearCourses as $course) {
                    $gradePoint = 0.00;
                    $credits = $course->credits;

                    // Get marks for this course
                    $theoryMark = TheoryMark::where('user_id', $userId)
                        ->where('course_id', $course->id)
                        ->where('session', $session)
                        ->first();

                    $labMark = LabMark::where('user_id', $userId)
                        ->where('course_id', $course->id)
                        ->where('session', $session)
                        ->first();

                    $specialMark = SpecialMark::where('user_id', $userId)
                        ->where('course_id', $course->id)
                        ->where('session', $session)
                        ->first();

                    if ($theoryMark) {
                        $gradePoint = max($gradePoint, $theoryMark->grade_point);
                    }
                    if ($labMark) {
                        $gradePoint = max($gradePoint, $labMark->grade_point);
                    }
                    if ($specialMark) {
                        $gradePoint = max($gradePoint, $specialMark->grade_point);
                    }

                    // Always include the course in the calculation.
                    $allCgpaPoints += $gradePoint * $credits;
                    $allCgpaCredits += $credits;

                    // Credits are only "completed" if the student passed.
                    if ($gradePoint > 0) {
                        $allCreditsCompleted += $credits;
                    }
                }
            }
        }

        $cgpa = $allCgpaCredits > 0 ? round($allCgpaPoints / $allCgpaCredits, 2) : 0;

        return [
            'tgpa' => $tgpa,
            'cgpa' => $cgpa,
            'credits_completed' => $creditsCompleted,
            'total_credits' => $totalCredits,
            'cumulative_credits' => $allCreditsCompleted,
            'total_cumulative_credits' => $allCgpaCredits
        ];
    }

    public function getStudentsWithMarksApi(Request $request)
    {
        $session = $request->get('session');
        $academicYearId = $request->get('academic_year_id');
        $termId = $request->get('term_id');

        $userIds = $this->getStudentsWithMarks($session, $academicYearId, $termId);

        $students = User::whereIn('id', $userIds)
            ->whereNotNull('studentid')
            ->get(['id', 'name', 'studentid']);

        return response()->json($students);
    }


    public function getMarksPreview(Request $request)
    {
        try {
            // Log the incoming request for debugging
            \Log::info('getMarksPreview called with parameters:', $request->all());

            $userId = $request->get('user_id');
            $session = $request->get('session');
            $academicYearId = $request->get('academic_year_id');
            $termId = $request->get('term_id');

            // Validate required parameters
            if (!$userId || !$session || !$academicYearId || !$termId) {
                return response()->json([
                    'error' => 'Missing required parameters',
                    'received' => $request->all()
                ], 400);
            }

            // Check if student exists
            $student = User::find($userId);
            if (!$student) {
                return response()->json(['error' => 'Student not found'], 404);
            }

            // Check if academic year and term exist
            $academicYear = AcademicYear::find($academicYearId);
            $term = Term::find($termId);

            if (!$academicYear || !$term) {
                return response()->json(['error' => 'Invalid academic year or term'], 404);
            }

            // Get courses for this academic year and term
            $courses = Course::where('academic_year_id', $academicYearId)
                ->where('term_id', $termId)
                ->get();

            \Log::info("Found {$courses->count()} courses for academic year {$academicYearId} and term {$termId}");

            if ($courses->isEmpty()) {
                return response()->json([
                    'marks' => [],
                    'estimated_tgpa' => 0,
                    'total_credits' => 0,
                    'message' => 'No courses found for this academic year and term'
                ]);
            }

            $marks = collect();
            $totalGradePoints = 0;
            $totalCredits = 0;

            foreach ($courses as $course) {
                $gradePoint = 0.00;
                $grade = 'F';
                $markType = 'N/A';

                // Check for marks in all three tables
                $theoryMark = TheoryMark::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->where('academic_year_id', $academicYearId)
                    ->where('term_id', $termId)
                    ->first();

                $labMark = LabMark::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->where('academic_year_id', $academicYearId)
                    ->where('term_id', $termId)
                    ->first();

                $specialMark = SpecialMark::where('user_id', $userId)
                    ->where('course_id', $course->id)
                    ->where('session', $session)
                    ->where('academic_year_id', $academicYearId)
                    ->where('term_id', $termId)
                    ->first();

                // Determine the best grade among all mark types
                if ($theoryMark && $theoryMark->grade_point > $gradePoint) {
                    $gradePoint = $theoryMark->grade_point;
                    $grade = $theoryMark->grade;
                    $markType = 'Theory';
                }
                if ($labMark && $labMark->grade_point > $gradePoint) {
                    $gradePoint = $labMark->grade_point;
                    $grade = $labMark->grade;
                    $markType = 'Lab';
                }
                if ($specialMark && $specialMark->grade_point > $gradePoint) {
                    $gradePoint = $specialMark->grade_point;
                    $grade = $specialMark->grade;
                    $markType = 'Special';
                }

                $marks->push([
                    'course' => [
                        'name' => $course->name,
                        'code' => $course->code ?? '',
                        'credits' => $course->credits
                    ],
                    'grade_point' => $gradePoint,
                    'grade' => $grade,
                    'type' => $markType,
                ]);

                $totalGradePoints += $gradePoint * $course->credits;
                $totalCredits += $course->credits;
            }

            $estimatedTgpa = $totalCredits > 0 ? round($totalGradePoints / $totalCredits, 2) : 0;

            \Log::info("Marks calculation completed. TGPA: {$estimatedTgpa}, Total Credits: {$totalCredits}");

            return response()->json([
                'marks' => $marks,
                'estimated_tgpa' => $estimatedTgpa,
                'total_credits' => $totalCredits,
                'student' => $student->name,
                'session' => $session,
                'academic_year' => $academicYear->name,
                'term' => $term->name
            ]);

        } catch (\Exception $e) {
            \Log::error("Error in getMarksPreview: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());

            return response()->json([
                'error' => 'An internal server error occurred while loading marks.',
                'details' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }


    public function bulkDownload(Request $request)
    {
        // This is a placeholder. Implement your bulk download logic here.
        return redirect()->back()->with('success', 'Bulk download started!');
    }

    public function bulkRegenerate(Request $request)
    {
        // This is a placeholder. Implement your bulk regenerate logic here.
        return redirect()->back()->with('success', 'Bulk regeneration started!');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session' => 'required|string',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term_id' => 'required|exists:terms,id'
        ]);

        $userId = $request->user_id;
        $session = $request->session;
        $academicYearId = $request->academic_year_id;
        $termId = $request->term_id;

        // Check if any marks exist for this student, session, academic year, and term
        $marksExist = $this->checkMarksExist($userId, $session, $academicYearId, $termId);

        if (!$marksExist) {
            return response('<div class="p-4 bg-red-50 border border-red-200 rounded-lg text-center">
                <i class="fas fa-times-circle text-red-500 text-2xl mb-2"></i>
                <p class="text-sm text-red-800 font-semibold">No Marks Found</p>
                <p class="text-xs text-red-700 mt-1">No marks found for this student in the specified session, year, and term.</p>
            </div>', 200);
        }

        // Calculate TGPA and CGPA
        $calculations = $this->calculateGPA($userId, $session, $academicYearId, $termId);

        // Create temporary marksheet for preview
        $marksheet = new Marksheet([
            'user_id' => $userId,
            'session' => $session,
            'academic_year_id' => $academicYearId,
            'term_id' => $termId,
            'tgpa' => $calculations['tgpa'],
            'cgpa' => $calculations['cgpa'],
            'credits_completed' => $calculations['credits_completed'],
            'total_credits' => $calculations['total_credits'],
            'cumulative_credits' => $calculations['cumulative_credits'],
            'total_cumulative_credits' => $calculations['total_cumulative_credits'],
            'generated_at' => now(),
            'generated_by' => auth()->id(),
            'status' => 'preview'
        ]);

        // Load relationships manually since it's not saved to DB
        $marksheet->student = User::find($userId);
        $marksheet->academicYear = AcademicYear::find($academicYearId);
        $marksheet->term = Term::find($termId);
        $marksheet->generatedBy = auth()->user();

        $marks = $this->getMarksForPreview($userId, $session, $academicYearId, $termId);

        return view('admin.marksheets.pdf-template', compact('marksheet', 'marks'));
    }

    private function getMarksForPreview($userId, $session, $academicYearId, $termId)
    {
        $courses = Course::where('academic_year_id', $academicYearId)
            ->where('term_id', $termId)
            ->get();

        $marks = collect();

        foreach ($courses as $course) {
            $gradePoint = 0.00;
            $grade = 'F';
            $markType = 'N/A';
            $totalMarks = 0;
            $foundMark = null;

            // Check for marks in all three tables
            $theoryMark = TheoryMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->where('academic_year_id', $academicYearId)
                ->where('term_id', $termId)
                ->first();

            $labMark = LabMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->where('academic_year_id', $academicYearId)
                ->where('term_id', $termId)
                ->first();

            $specialMark = SpecialMark::where('user_id', $userId)
                ->where('course_id', $course->id)
                ->where('session', $session)
                ->where('academic_year_id', $academicYearId)
                ->where('term_id', $termId)
                ->first();

            // Determine the best grade among all mark types
            if ($theoryMark && $theoryMark->grade_point > $gradePoint) {
                $gradePoint = $theoryMark->grade_point;
                $grade = $theoryMark->grade;
                $markType = 'Theory';
                $totalMarks = $theoryMark->total_marks ?? 0;
                $foundMark = $theoryMark;
            }
            if ($labMark && $labMark->grade_point > $gradePoint) {
                $gradePoint = $labMark->grade_point;
                $grade = $labMark->grade;
                $markType = 'Lab';
                $totalMarks = $labMark->total_marks ?? 0;
                $foundMark = $labMark;
            }
            if ($specialMark && $specialMark->grade_point > $gradePoint) {
                $gradePoint = $specialMark->grade_point;
                $grade = $specialMark->grade;
                $markType = 'Special';
                $totalMarks = $specialMark->total_marks ?? 0;
                $foundMark = $specialMark;
            }

            $marks->push((object) [
                'course' => $course,
                'grade_point' => $gradePoint,
                'grade' => $grade,
                'type' => $markType,
                'total_marks' => $totalMarks,
                'mark_data' => $foundMark
            ]);
        }

        return $marks;
    }

    public function previewPDF($id)
    {
        $marksheet = Marksheet::with(['student', 'academicYear', 'term'])->findOrFail($id);
        $marks = $marksheet->getAllMarks();

        return view('admin.marksheets.pdf-template', compact('marksheet', 'marks'));
    }

    public function sendEmail($id)
    {
        // This is a placeholder for email functionality
        return redirect()->back()->with('success', 'Email feature not yet implemented.');
    }

    private function generateAndSavePDF($marksheet)
    {
        try {
            // Load the marksheet with relationships
            $marksheet->load(['student', 'academicYear', 'term']);
            $marks = $marksheet->getAllMarks();

            // Generate the PDF using the original pdf template
            $pdf = Pdf::loadView('admin.marksheets.pdf-template', compact('marksheet', 'marks'))
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'serif',
                    'isRemoteEnabled' => true,
                    'isHtml5ParserEnabled' => true,
                    'isPhpEnabled' => true
                ]);

            // Create filename
            $student = $marksheet->student;
            $filename = str_replace(' ', '_', $student->name) . '_' .
                $marksheet->session . '_' .
                $marksheet->academicYear->name . 'Y_' .
                $marksheet->term->name . 'T_marksheet.pdf';

            // Ensure the directory exists
            $directory = storage_path('app/public/marksheets');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            // Save the PDF file
            $filePath = $directory . '/' . $filename;
            $pdf->save($filePath);

            // Update marksheet with file information
            $marksheet->update([
                'file_path' => 'marksheets/' . $filename,
                'pdf_filename' => $filename
            ]);

            return true;
        } catch (\Exception $e) {
            \Log::error("Error generating PDF for marksheet {$marksheet->id}: " . $e->getMessage());
            return false;
        }
    }
}
