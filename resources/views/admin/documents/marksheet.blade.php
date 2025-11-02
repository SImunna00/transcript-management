<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marksheet</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            max-width: 80px;
        }

        .university-name {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }

        .department-name {
            font-size: 16px;
            margin: 5px 0;
        }

        .document-title {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
            text-decoration: underline;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .student-info td {
            padding: 5px;
        }

        .student-info .label {
            font-weight: bold;
            width: 150px;
        }

        .marks-table {
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

        .marks-table th {
            background-color: #f2f2f2;
        }

        .result-summary {
            margin-top: 20px;
        }

        .result-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .result-summary th,
        .result-summary td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        .result-summary th {
            background-color: #f2f2f2;
        }

        .footer {
            margin-top: 50px;
        }

        .signature-line {
            margin-top: 30px;
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
            font-weight: bold;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 70px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- University Logo would go here -->
        <div class="university-name">Noakhali Science and Technology University</div>
        <div class="department-name">Department of Information & Communication Engineering</div>
        <div class="document-title">MARKSHEET</div>
    </div>

    <table class="student-info">
        <tr>
            <td class="label">Student Name:</td>
            <td>{{ $student->name }}</td>
            <td class="label">Student ID:</td>
            <td>{{ $student->studentid }}</td>
        </tr>
        <tr>
            <td class="label">Father's Name:</td>
            <td>{{ $student->father_name }}</td>
            <td class="label">Mother's Name:</td>
            <td>{{ $student->mother_name }}</td>
        </tr>
        <tr>
            <td class="label">Session:</td>
            <td>{{ $student->session }}</td>
            <td class="label">Hall:</td>
            <td>{{ $student->hall_name }}</td>
        </tr>
        <tr>
            <td class="label">Year:</td>
            <td>{{ $documentRequest->year }}</td>
            <td class="label">Term:</td>
            <td>{{ $documentRequest->term }}</td>
        </tr>
    </table>

    <h3>Theory Courses</h3>
    <table class="marks-table">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Credit Hours</th>
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
                    <td>{{ $mark->course->code }}</td>
                    <td>{{ $mark->course->title }}</td>
                    <td>{{ $mark->course->credit_hours }}</td>
                    <td>{{ $mark->class_test }}</td>
                    <td>{{ $mark->attendance }}</td>
                    <td>{{ $mark->final_exam }}</td>
                    <td>{{ $mark->total }}</td>
                    <td>{{ $mark->grade }}</td>
                    <td>{{ $mark->grade_point }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">No theory courses found</td>
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
                <th>Credit Hours</th>
                <th>Lab Report</th>
                <th>Attendance</th>
                <th>Exam</th>
                <th>Viva</th>
                <th>Total</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            @forelse($labMarks as $mark)
                <tr>
                    <td>{{ $mark->course->code }}</td>
                    <td>{{ $mark->course->title }}</td>
                    <td>{{ $mark->course->credit_hours }}</td>
                    <td>{{ $mark->lab_report }}</td>
                    <td>{{ $mark->attendance }}</td>
                    <td>{{ $mark->exam }}</td>
                    <td>{{ $mark->viva }}</td>
                    <td>{{ $mark->total }}</td>
                    <td>{{ $mark->grade }}</td>
                    <td>{{ $mark->grade_point }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align: center;">No lab courses found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($specialMarks) > 0)
        <h3>Special Courses</h3>
        <table class="marks-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credit Hours</th>
                    <th>Project</th>
                    <th>Presentation</th>
                    <th>Report</th>
                    <th>Total</th>
                    <th>Grade</th>
                    <th>Grade Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach($specialMarks as $mark)
                    <tr>
                        <td>{{ $mark->course->code }}</td>
                        <td>{{ $mark->course->title }}</td>
                        <td>{{ $mark->course->credit_hours }}</td>
                        <td>{{ $mark->project }}</td>
                        <td>{{ $mark->presentation }}</td>
                        <td>{{ $mark->report }}</td>
                        <td>{{ $mark->total }}</td>
                        <td>{{ $mark->grade }}</td>
                        <td>{{ $mark->grade_point }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="result-summary">
        <h3>Semester Result Summary</h3>
        <table>
            <tr>
                <th>Total Credits</th>
                <th>Credits Earned</th>
                <th>Semester GPA</th>
                <th>Cumulative GPA</th>
            </tr>
            <tr>
                <td>{{ $semesterResult->total_credits ?? 'N/A' }}</td>
                <td>{{ $semesterResult->credits_earned ?? 'N/A' }}</td>
                <td>{{ $semesterResult->gpa ?? 'N/A' }}</td>
                <td>{{ $semesterResult->cgpa ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <div class="signatures">
            <div class="signature-line">Examination Controller</div>
            <div class="signature-line">Head of Department</div>
            <div class="signature-line">Dean of Faculty</div>
        </div>
    </div>
</body>

</html>