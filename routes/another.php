







<!-- 4. ADMIN MARKSHEET PDF TEMPLATE - resources/views/admin/marksheets/pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Academic Transcript</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .university-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .university-address {
            font-size: 12px;
            margin-bottom: 10px;
        }
        
        .contact-info {
            font-size: 10px;
            text-align: right;
            margin-bottom: 20px;
        }
        
        .transcript-title {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 0;
        }
        
        .info-section {
            border: 1px solid #333;
            border-top: none;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 10px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .grading-scheme {
            float: right;
            width: 200px;
            border: 1px solid #333;
            margin-left: 20px;
        }
        
        .grading-scheme-header {
            background-color: #f0f0f0;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            border-bottom: 1px solid #333;
        }
        
        .grading-scheme table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .grading-scheme td {
            padding: 4px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10px;
        }
        
        .student-info {
            float: left;
            width: calc(100% - 220px);
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        .examination-title {
            font-size: 14px;
            font-weight: bold;
            margin: 20px 0 10px 0;
            clear: both;
        }
        
        .marks-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        .summary-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        
        .signatures {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-section {
            text-align: center;
            width: 200px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 40px;
        }
        
        .print-date {
            text-align: right;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="contact-info">
            TEL: 0321-62812<br>
            FAX: 0321-62786<br>
            www.nstu.edu.bd
        </div>
        
        <div class="university-name">Noakhali Science and Technology University</div>
        <div class="university-address">Noakhali - 3814, Bangladesh</div>
    </div>

    <!-- Transcript Title -->
    <div class="transcript-title">ACADEMIC TRANSCRIPT</div>

    <!-- Student Information and Grading Scheme -->
    <div class="info-section clearfix">
        <div class="student-info">
            <div class="info-row">
                <span class="info-label">Department of</span> Information and Communication Engineering
            </div>
            <div class="info-row">
                <span class="info-label">Bachelor of</span> Science (Engg.)
            </div>
            <div class="info-row">
                <span class="info-label">Session:</span> {{ $marksheet->session }}
            </div>
            <div class="info-row">
                <span class="info-label">Student name:</span> {{ $marksheet->student->name }}
            </div>
            <div class="info-row">
                <span class="info-label">Student ID:</span> {{ $marksheet->student->studentid ?? 'N/A' }}
            </div>
        </div>

        <div class="grading-scheme">
            <div class="grading-scheme-header">GRADING SCHEME</div>
            <table>
                <tr>
                    <td><strong>Range</strong></td>
                    <td><strong>Grade point</strong></td>
                    <td><strong>Grade</strong></td>
                </tr>
                <tr><td>80% or Above</td><td>4.00</td><td>A+</td></tr>
                <tr><td>75% - 79%</td><td>3.75</td><td>A</td></tr>
                <tr><td>70% - 74%</td><td>3.50</td><td>A-</td></tr>
                <tr><td>65% - 69%</td><td>3.25</td><td>B+</td></tr>
                <tr><td>60% - 64%</td><td>3.00</td><td>B</td></tr>
                <tr><td>55% - 59%</td><td>2.75</td><td>B-</td></tr>
                <tr><td>50% - 54%</td><td>2.50</td><td>C+</td></tr>
                <tr><td>45% - 49%</td><td>2.00</td><td>C</td></tr>
                <tr><td>40% - 44%</td><td>1.00</td><td>D</td></tr>
                <tr><td><40%</td><td>0.00</td><td>F</td></tr>
            </table>
        </div>
    </div>

    <!-- Examination Title -->
    <div class="examination-title">{{ $marksheet->year_term_display }} Examination</div>

    <!-- Marks Table -->
    <table class="marks-table">
        <thead>
            <tr>
                <th>Course code</th>
                <th>Course title</th>
                <th>Credits</th>
                <th>GP</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marks as $mark)
            <tr>
                <td>{{ $mark->course->code }}</td>
                <td>{{ $mark->course->name }}</td>
                <td>{{ number_format($mark->course->credits, 2) }}</td>
                <td>{{ number_format($mark->grade_point, 2) }}</td>
                <td>{{ $mark->grade }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary -->
    <div style="margin-bottom: 40px;">
        <div style="display: flex; justify-content: space-between;">
            <div>
                <strong>Credits completed: {{ $marksheet->credits_completed }} out of {{ $marksheet->total_credits }}</strong>
            </div>
            <div>
                <strong>TGPA: {{ number_format($marksheet->tgpa, 2) }}</strong>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; margin-top: 10px;">
            <div>
                <strong>Cumulative credits: {{ $marksheet->cumulative_credits }} out of {{ $marksheet->total_cumulative_credits }}</strong>
            </div>
            <div>
                <strong>CGPA: {{ number_format($marksheet->cgpa, 2) }}</strong>
            </div>
        </div>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature-section">
            <div class="signature-line"></div>
            <div>Prepared by</div>
        </div>
        <div class="signature-section">
            <div class="signature-line"></div>
            <div>Compared by</div>
        </div>
        <div class="signature-section">
            <div class="signature-line"></div>
            <div>Controller of Examinations</div>
        </div>
    </div>

    <!-- Print Date -->
    <div class="print-date">
        Printed on: {{ date('d/m/Y') }}
    </div>
</body>
</html>

<!-- 5. TEACHER MARKS ENTRY FORM (Updated for your schema) - resources/views/teacher/marks/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-8">
            <h2 class="text-2xl font-bold mb-6">Enter Student Marks</h2>
            
            <form action="{{ route('teacher.marks.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                        <select name="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->studentid }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                        <select name="session" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Session</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                        <select name="course_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->code }} - {{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Mark Type Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mark Type</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="mark_type" value="theory" class="mr-2" onchange="showMarkForm('theory')">
                            <span>Theory</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="mark_type" value="lab" class="mr-2" onchange="showMarkForm('lab')">
                            <span>Lab</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="mark_type" value="special" class="mr-2" onchange="showMarkForm('special')">
                            <span>Special</span>
                        </label>
                    </div>
                </div>

                <!-- Theory Marks Form -->
                <div id="theory_form" class="mark-form hidden">
                    <h3 class="text-lg font-semibold mb-4">Theory Marks</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Participation (10)</label>
                            <input type="number" name="participation" min="0" max="10" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateTheoryTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">CT (20)</label>
                            <input type="number" name="ct" min="0" max="20" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateTheoryTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester Final (70)</label>
                            <input type="number" name="semester_final" min="0" max="70" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateTheoryTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                            <input type="number" name="theory_total" readonly 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                            <div class="mt-1 text-sm">
                                Grade: <span id="theory_grade">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lab Marks Form -->
                <div id="lab_form" class="mark-form hidden">
                    <h3 class="text-lg font-semibold mb-4">Lab Marks</h3>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Attendance (20)</label>
                            <input type="number" name="attendance" min="0" max="20" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateLabTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Report (20)</label>
                            <input type="number" name="report" min="0" max="20" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateLabTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lab Work (40)</label>
                            <input type="number" name="lab_work" min="0" max="40" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateLabTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Viva (20)</label>
                            <input type="number" name="viva" min="0" max="20" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateLabTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total</label>
                            <input type="number" name="lab_total" readonly 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                            <div class="mt-1 text-sm">
                                Grade: <span id="lab_grade">-</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Special Marks Form -->
                <div id="special_form" class="mark-form hidden">
                    <h3 class="text-lg font-semibold mb-4">Special Marks</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Marks (100)</label>
                            <input type="number" name="full_marks" min="0" max="100" 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" 
                                   onchange="calculateSpecialGrade()">
                        </div>
                        <div>
                            <div class="mt-6 text-sm">
                                Grade: <span id="special_grade">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('teacher.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Save Marks
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showMarkForm(type) {
    // Hide all forms
    document.querySelectorAll('.mark-form').forEach(form => {
        form.classList.add('hidden');
    });
    
    // Show selected form
    document.getElementById(type + '_form').classList.remove('hidden');
}

function calculateGrade(total) {
    if (total >= 80) return 'A+';
    if (total >= 75) return 'A';
    if (total >= 70) return 'A-';
    if (total >= 65) return 'B+';
    if (total >= 60) return 'B';
    if (total >= 55) return 'B-';
    if (total >= 50) return 'C+';
    if (total >= 45) return 'C';
    if (total >= 40) return 'D';
    return 'F';
}

function calculateTheoryTotal() {
    const participation = parseInt(document.querySelector('input[name="participation"]').value) || 0;
    const ct = parseInt(document.querySelector('input[name="ct"]').value) || 0;
    const semesterFinal = parseInt(document.querySelector('input[name="semester_final"]').value) || 0;
    
    const total = participation + ct + semesterFinal;
    document.querySelector('input[name="theory_total"]').value = total;
    document.getElementById('theory_grade').textContent = calculateGrade(total);
}

function calculateLabTotal() {
    const attendance = parseInt(document.querySelector('input[name="attendance"]').value) || 0;
    const report = parseInt(document.querySelector('input[name="report"]').value) || 0;
    const labWork = parseInt(document.querySelector('input[name="lab_work"]').value) || 0;
    const viva = parseInt(document.querySelector('input[name="viva"]').value) || 0;
    
    const total = attendance + report + labWork + viva;
    document.querySelector('input[name="lab_total"]').value = total;
    document.getElementById('lab_grade').textContent = calculateGrade(total);
}

function calculateSpecialGrade() {
    const fullMarks = parseInt(document.querySelector('input[name="full_marks"]').value) || 0;
    document.getElementById('special_grade').textContent = calculateGrade(fullMarks);
}
</script>
@endsectiontable {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .marks-table th,
        .marks-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        
        .marks- overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">{{ $marksheets->where('status', 'approved')->count() }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Approved Marksheets</dt>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white
