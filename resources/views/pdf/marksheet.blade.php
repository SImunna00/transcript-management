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
            font-size: 12px;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .university-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .department-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .document-title {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .student-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .student-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .student-info table td {
            padding: 5px;
            vertical-align: top;
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
            font-weight: bold;
        }

        .summary {
            width: 100%;
            margin-top: 20px;
        }

        .summary table {
            width: 50%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary table td {
            padding: 5px;
            vertical-align: top;
        }

        .signatures {
            margin-top: 40px;
            width: 100%;
            display: table;
        }

        .signature-cell {
            display: table-cell;
            width: 33.33%;
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 70%;
            margin: 40px auto 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="university-name">Bangladesh University of Engineering and Technology</div>
            <div class="department-name">Department of {{ $department->name }}</div>
            <div class="document-title">Semester Final Marksheet - {{ $semester->name }}</div>
        </div>

        <div class="student-info">
            <table>
                <tr>
                    <td width="20%"><strong>Student ID:</strong></td>
                    <td width="30%">{{ $student->studentid }}</td>
                    <td width="20%"><strong>Session:</strong></td>
                    <td width="30%">{{ $session }}</td>
                </tr>
                <tr>
                    <td><strong>Student Name:</strong></td>
                    <td>{{ $student->name }}</td>
                    <td><strong>Semester:</strong></td>
                    <td>{{ $semester->name }}</td>
                </tr>
            </table>
        </div>

        <table class="marks-table">
            <thead>
                <tr>
                    <th rowspan="2">Course Code</th>
                    <th rowspan="2">Course Title</th>
                    <th rowspan="2">Credit</th>
                    <th colspan="3">Marks</th>
                    <th rowspan="2">Grade</th>
                    <th rowspan="2">Grade Point</th>
                </tr>
                <tr>
                    <th>CT/Lab Work</th>
                    <th>Final</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $mark)
                    <tr>
                        <td>{{ $mark['course']->course_code }}</td>
                        <td style="text-align: left;">{{ $mark['course']->title }}</td>
                        <td>{{ $mark['course']->credits }}</td>
                        @if($mark['course']->course_type === 'theory')
                            <td>{{ $mark['mark']->participation + $mark['mark']->ct }}</td>
                            <td>{{ $mark['mark']->semester_final }}</td>
                            <td>{{ $mark['mark']->total }}</td>
                        @elseif($mark['course']->course_type === 'lab')
                            <td>{{ $mark['mark']->report + $mark['mark']->lab_work + $mark['mark']->attendance }}</td>
                            <td>{{ $mark['mark']->viva }}</td>
                            <td>{{ $mark['mark']->total }}</td>
                        @elseif($mark['course']->course_type === 'special')
                            <td colspan="2">Special Course</td>
                            <td>{{ $mark['mark']->full_marks }}</td>
                        @endif
                        <td>{{ $mark['mark']->grade }}</td>
                        <td>{{ $mark['mark']->grade_point }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary">
            <table>
                <tr>
                    <td width="60%"><strong>Total Credits:</strong></td>
                    <td width="40%">{{ $semesterResult->total_credits }}</td>
                </tr>
                <tr>
                    <td><strong>GPA:</strong></td>
                    <td>{{ number_format($semesterResult->gpa, 2) }}</td>
                </tr>
                @if(isset($transcript))
                    <tr>
                        <td><strong>CGPA:</strong></td>
                        <td>{{ number_format($transcript->cgpa, 2) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Credits Completed:</strong></td>
                        <td>{{ $transcript->total_credits_completed }}</td>
                    </tr>
                @endif
            </table>
        </div>

        <div class="signatures">
            <div class="signature-cell">
                <div class="signature-line"></div>
                <div>Checked by</div>
            </div>
            <div class="signature-cell">
                <div class="signature-line"></div>
                <div>Head of the Department</div>
            </div>
            <div class="signature-cell">
                <div class="signature-line"></div>
                <div>Controller of Examinations</div>
            </div>
        </div>
    </div>
</body>

</html>