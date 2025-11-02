<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPdf\Facade\Pdf;

class DocumentRequestController extends Controller
{
    /**
     * Display a listing of the document requests.
     */
    public function index(Request $request)
    {
        $query = DocumentRequest::with('user');

        // Apply filters if provided
        if ($request->has('document_type') && $request->document_type) {
            $query->where('document_type', $request->document_type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        $requests = $query->latest()->paginate(15);

        return view('admin.document-requests.index', compact('requests'));
    }

    /**
     * Display the specified document request.
     */
    public function show(DocumentRequest $documentRequest)
    {
        // Load relationships
        $documentRequest->load(['user', 'approvedBy']);

        return view('admin.document-requests.show', compact('documentRequest'));
    }

    /**
     * Update the status of the document request.
     */
    public function updateStatus(Request $request, DocumentRequest $documentRequest)
    {
        $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected'],
        ]);

        $documentRequest->status = $request->status;

        if ($request->status === 'approved') {
            $documentRequest->approved_by = Auth::id();
        }

        $documentRequest->save();

        return back()->with('success', 'Document request status updated successfully.');
    }

    /**
     * Generate PDF for the document request.
     */
    public function generatePdf(DocumentRequest $documentRequest)
    {
        // Check if request is approved and paid
        if ($documentRequest->status !== 'approved' || $documentRequest->payment_status !== 'paid') {
            return back()->with('error', 'Cannot generate PDF for requests that are not approved or paid.');
        }

        // Load student information
        $student = $documentRequest->user;

        // Generate PDF based on document type
        if ($documentRequest->document_type === 'marksheet') {
            $pdf = $this->generateMarksheetPdf($documentRequest, $student);
        } else {
            $pdf = $this->generateTestimonialPdf($documentRequest, $student);
        }

        // Save PDF to storage
        $filename = strtolower($documentRequest->document_type) . '_' . $student->studentid . '_' . time() . '.pdf';
        $path = 'documents/' . $filename;

        Storage::put($path, $pdf->output());

        // Update document request with PDF path
        $documentRequest->pdf_path = $path;
        $documentRequest->save();

        return back()->with('success', 'PDF generated successfully.');
    }

    /**
     * Generate marksheet PDF
     */
    private function generateMarksheetPdf(DocumentRequest $documentRequest, $student)
    {
        // Get semester results for the specified year and term
        $semesterResult = $student->semesterResults()
            ->where('year', $documentRequest->year)
            ->where('term', $documentRequest->term)
            ->first();

        // Get course marks for the semester
        $theoryMarks = $student->theoryMarks()
            ->where('year', $documentRequest->year)
            ->where('term', $documentRequest->term)
            ->get();

        $labMarks = $student->labMarks()
            ->where('year', $documentRequest->year)
            ->where('term', $documentRequest->term)
            ->get();

        $specialMarks = $student->specialMarks()
            ->where('year', $documentRequest->year)
            ->where('term', $documentRequest->term)
            ->get();

        // Generate PDF
        $data = [
            'student' => $student,
            'documentRequest' => $documentRequest,
            'semesterResult' => $semesterResult,
            'theoryMarks' => $theoryMarks,
            'labMarks' => $labMarks,
            'specialMarks' => $specialMarks,
        ];

        return PDF::loadView('admin.documents.marksheet', $data);
    }

    /**
     * Generate testimonial PDF
     */
    private function generateTestimonialPdf(DocumentRequest $documentRequest, $student)
    {
        // Get final semester results for the student
        $finalResult = $student->semesterResults()
            ->orderByDesc('year')
            ->orderByDesc('term')
            ->first();

        // Generate PDF
        $data = [
            'student' => $student,
            'documentRequest' => $documentRequest,
            'finalResult' => $finalResult,
        ];

        return PDF::loadView('admin.documents.testimonial', $data);
    }

    /**
     * Download the generated PDF
     */
    public function downloadPdf(DocumentRequest $documentRequest)
    {
        if (!$documentRequest->pdf_path) {
            return back()->with('error', 'PDF not yet generated for this request.');
        }

        return Storage::download($documentRequest->pdf_path);
    }
}
