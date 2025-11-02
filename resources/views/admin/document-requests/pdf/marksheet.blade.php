<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Marksheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .university-name {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .department-name {
            font-size: 16pt;
            margin-bottom: 5px;
        }

        .document-title {
            font-size: 14pt;
            margin-top: 15px;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .student-info td {
            padding: 5px;
        }

        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .marks-table th,
        .marks-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .marks-table th {
            background-color: #f2f2f2;
        }

        .result-summary {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .result-summary td {
            padding: 5px;
        }

        .signature {
            margin-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
            text-align: center;
        }

        .signature-name {
            margin-top: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10pt;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="university-name">Noakhali Science and Technology University</div>
            <div class="department-name">Department of Information and Communication Engineering</div>
            <div class="document-title">MARKSHEET</div>
        </div>

        <table class="student-info">
            <tr>
                <td><strong>Student Name:</strong></td>
                <td>{{ $student->name }}</td>
                <td><strong>Student ID:</strong></td>
                <td>{{ $student->studentid }}</td>
            </tr>
            <tr>
                <td><strong>Father's Name:</strong></td>
                <td>{{ $student->father_name ?? 'N/A' }}</td>
                <td><strong>Mother's Name:</strong></td>
                <td>{{ $student->mother_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>Session:</strong></td>
                <td>{{ $student->session ?? 'N/A' }}</td>
                <td><strong>Year & Term:</strong></td>
                <td>{{ $year }}rd Year {{ $term }}st Term</td>
            </tr>
            <tr>
                <td><strong>Hall:</strong></td>
                <td>{{ $student->hall_name ?? 'N/A' }}</td>
                <td><strong>Room No:</strong></td>
                <td>{{ $student->room_number ?? 'N/A' }}</td>
            </tr>
        </table>

        <h3>Theory Courses</h3>
        <table class="marks-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit</th>
                    <th>Class Test</th>
                    <th>Attendance</th>
                    <th>Final Exam</th>
                    <th>Total</th>
                    <th>Grade</th>
                    <th>Grade Point</th>
                </tr>
            </thead>
            <tbody>
                @forelse($theoryMarks as $mark)
                    <tr>
                        <td>{{ $mark->course->code ?? 'N/A' }}</td>
                        <td>{{ $mark->course->title ?? 'N/A' }}</td>
                        <td>{{ $mark->course->credit ?? 'N/A' }}</td>
                        <td>{{ $mark->class_test }}</td>
                        <td>{{ $mark->attendance }}</td>
                        <td>{{ $mark->final_exam }}</td>
                        <td>{{ $mark->total }}</td>
                        <td>{{ $mark->letter_grade }}</td>
                        <td>{{ $mark->grade_point }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No theory course marks found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Lab Courses</h3>
        <table class="marks-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit</th>
                    <th>Lab Performance</th>
                    <th>Lab Report</th>
                    <th>Lab Final</th>
                    <th>Total</th>
                    <th>Grade</th>
                    <th>Grade Point</th>
                </tr>
            </thead>
            <tbody>
                @forelse($labMarks as $mark)
                    <tr>
                        <td>{{ $mark->course->code ?? 'N/A' }}</td>
                        <td>{{ $mark->course->title ?? 'N/A' }}</td>
                        <td>{{ $mark->course->credit ?? 'N/A' }}</td>
                        <td>{{ $mark->lab_performance }}</td>
                        <td>{{ $mark->lab_report }}</td>
                        <td>{{ $mark->lab_final }}</td>
                        <td>{{ $mark->total }}</td>
                        <td>{{ $mark->letter_grade }}</td>
                        <td>{{ $mark->grade_point }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">No lab course marks found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="result-summary">
            <tr>
                <td width="60%"></td>
                <td><strong>Term GPA:</strong></td>
                <td>{{ $semesterResult->gpa ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Total Credits Completed:</strong></td>
                <td>{{ $semesterResult->total_credits ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td></td>
                <td><strong>Result:</strong></td>
                <td>{{ $semesterResult && $semesterResult->gpa >= 2.0 ? 'PASSED' : 'FAILED' }}</td>
            </tr>
        </table>

        <div class="signature">
            <table width="100%">
                <tr>
                    <td width="33%" align="center">
                        <div class="signature-line"></div>
                        <div class="signature-name">Exam Controller</div>
                    </td>
                    <td width="33%" align="center">
                        <div class="signature-line"></div>
                        <div class="signature-name">Chairman</div>
                    </td>
                    <td width="33%" align="center">
                        <div class="signature-line"></div>
                        <div class="signature-name">Dean</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>This document is computer generated and does not require a signature. Verification can be done through
                the university portal.</p>
            <p>Document ID: {{ $documentRequest->id }} | Generated on: {{ date('F d, Y') }}</p>
        </div>
    </div>
</body>

</html>