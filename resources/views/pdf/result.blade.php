<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Academic Result</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 10px;
        }

        .header img {
            height: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 5px 0;
            color: #0d6efd;
            font-size: 20px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: normal;
        }

        .document-title {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
        }

        .info-section {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section table td {
            padding: 5px;
        }

        .info-section table .label {
            font-weight: bold;
            width: 150px;
        }

        .result-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .result-table th,
        .result-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .result-table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .result-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .grade-summary {
            margin: 20px 0;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        .grade-summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grade-summary-table td {
            padding: 5px;
        }

        .grade-summary-table .label {
            font-weight: bold;
            width: 150px;
        }

        .mark-details {
            margin-top: 20px;
        }

        .mark-details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .mark-details-table th,
        .mark-details-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .mark-details-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .mark-details-table td {
            text-align: center;
        }

        .grading-system {
            width: 100%;
            font-size: 10px;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .grading-table {
            width: 100%;
            border-collapse: collapse;
        }

        .grading-table th,
        .grading-table td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
        }

        .grading-table th {
            background-color: #f0f0f0;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .signatures {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 33%;
        }

        .signature-line {
            margin: 50px auto 10px;
            width: 80%;
            border-bottom: 1px solid #000;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('assests/image/nstu_logo.png') }}" alt="NSTU Logo">
        <h1>Noakhali Science and Technology University</h1>
        <h2>Office of the Controller of Examinations</h2>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        Academic Transcript
    </div>

    <!-- Student Information -->
    <div class="info-section">
        <table>
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $student->name }}</td>
                <td class="label">Student ID:</td>
                <td>{{ $student->studentid }}</td>
            </tr>
            <tr>
                <td class="label">Academic Year:</td>
                <td>{{ $result->academic_year }}</td>
                <td class="label">Term:</td>
                <td>{{ $result->term }}</td>
            </tr>
            <tr>
                <td class="label">Program:</td>
                <td>Bachelor of Science</td>
                <td class="label">Department:</td>
                <td>{{ $course->department }}</td>
            </tr>
        </table>
    </div>

    <!-- Course Results -->
    <h3>Course Results</h3>
    <table class="result-table">
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Credit</th>
                <th>Marks</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allResults as $res)
                <tr>
                    <td>{{ $res->course->course_code }}</td>
                    <td>{{ $res->course->title }}</td>
                    <td>{{ number_format($res->course->credits, 1) }}</td>
                    <td>{{ number_format($res->total_marks, 2) }}</td>
                    <td>{{ $res->letter_grade }}</td>
                    <td>{{ number_format($res->grade_point, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Grade Summary -->
    <div class="grade-summary">
        <table class="grade-summary-table">
            <tr>
                <td class="label">Total Credits:</td>
                <td>{{ number_format($totalCredits, 1) }}</td>
                <td class="label">Term GPA (TGPA):</td>
                <td>{{ number_format($tgpa, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Individual Course Mark Details -->
    <div class="mark-details">
        <h3>Detailed Marks for {{ $course->course_code }} - {{ $course->title }}</h3>
        <table class="mark-details-table">
            <thead>
                <tr>
                    <th>Attendance</th>
                    <th>Class Test</th>
                    <th>Mid Term</th>
                    <th>Final</th>
                    <th>Viva</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $result->attendance }} / 10</td>
                    <td>{{ $result->class_test }} / 15</td>
                    <td>{{ $result->mid_term }} / 25</td>
                    <td>{{ $result->final }} / 40</td>
                    <td>{{ $result->viva }} / 10</td>
                    <td>{{ number_format($result->total_marks, 2) }} / 100</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Grading System -->
    <div class="grading-system">
        <h4>Grading System</h4>
        <table class="grading-table">
            <thead>
                <tr>
                    <th>Marks Range</th>
                    <th>Letter Grade</th>
                    <th>Grade Point</th>
                    <th>Marks Range</th>
                    <th>Letter Grade</th>
                    <th>Grade Point</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>80-100</td>
                    <td>A+</td>
                    <td>4.00</td>
                    <td>55-59</td>
                    <td>B-</td>
                    <td>2.75</td>
                </tr>
                <tr>
                    <td>75-79</td>
                    <td>A</td>
                    <td>3.75</td>
                    <td>50-54</td>
                    <td>C+</td>
                    <td>2.50</td>
                </tr>
                <tr>
                    <td>70-74</td>
                    <td>A-</td>
                    <td>3.50</td>
                    <td>45-49</td>
                    <td>C</td>
                    <td>2.25</td>
                </tr>
                <tr>
                    <td>65-69</td>
                    <td>B+</td>
                    <td>3.25</td>
                    <td>40-44</td>
                    <td>D</td>
                    <td>2.00</td>
                </tr>
                <tr>
                    <td>60-64</td>
                    <td>B</td>
                    <td>3.00</td>
                    <td>0-39</td>
                    <td>F</td>
                    <td>0.00</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="signature">
            <div class="signature-line"></div>
            <p>Course Teacher</p>
            <p>{{ $teacher->name }}</p>
        </div>
        <div class="signature">
            <div class="signature-line"></div>
            <p>Department Head</p>
        </div>
        <div class="signature">
            <div class="signature-line"></div>
            <p>Controller of Examinations</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Printed on: {{ $print_date }} | This is a system-generated document.</p>
        <p>NSTU Transcript Management System &copy; {{ date('Y') }}. All rights reserved.</p>
    </div>
</body>

</html>