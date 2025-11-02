<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Transcript - {{ $marksheet->student->name }}</title>
    <style>
        @page {
            margin: 15mm;
            size: A4 portrait;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
            background: #fff;
        }

        .container {
            width: 180mm;
            min-height: 267mm;
            margin: 0 auto;
            padding: 0;
            box-sizing: border-box;
        }

        /* Header Section */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5mm;
            width: 100%;
        }

        .logo {
            flex: 0 0 50px;
            width: 50px;
            min-width: 50px;
            text-align: center;
            margin-right: 5px;
        }

        .logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            text-align: center;
            border-radius: 50%;
        }

        .university-info {
            flex: 1;
            text-align: left;
            padding-left: 0;
        }

        .university-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 1px;
            margin-top: 0;
        }

        .university-address {
            font-size: 12px;
            margin-top: 0;
            margin-bottom: 0;
        }

        .contact-info {
            width: 120px;
            min-width: 100px;
            text-align: right;
            font-size: 10px;
            line-height: 1.1;
            margin-left: 5px;
        }

        .contact-info .web {
            font-size: 9px;
            margin-top: 2px;
        }

        /* Transcript Header */
        .transcript-header {
            background: #111;
            color: #fff;
            text-align: center;
            padding: 4px 0;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0 0 0;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            width: 100%;
            font-family: 'Times New Roman', Times, serif;
        }

        /* Info Table */
        .info-table {
            border-collapse: collapse;
            margin-top: 0;
            width: 100%;
            table-layout: fixed;
            margin-bottom: 5mm;
        }

        .info-table td {
            border: 1px solid #000;
            padding: 4px;
            font-size: 12px;
            vertical-align: middle;
        }

        .dept-title {
            font-size: 14px;
            font-weight: bold;
            text-align: left;
            letter-spacing: 0.3px;
            padding: 4px 8px;
            background: #fff;
        }

        .student-info-left {
            text-align: left;
            padding: 6px 8px;
            font-size: 12px;
            border-right: 1px solid #000;
            background: #fff;
        }

        .grading-scheme-vertical {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-weight: bold;
            text-align: center;
            letter-spacing: 0.5px;
            font-size: 12px;
            background: #fff;
            min-width: 20px;
        }

        .grading-table-container {
            text-align: left;
            padding: 0;
            background: #fff;
            font-size: 12px;
        }

        .grading-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .grading-table th {
            background: #fff;
            padding: 4px 3px;
            text-align: center;
            font-weight: bold;
            border: none;
        }

        .grading-table td {
            padding: 2px 3px;
            text-align: center;
            border: none;
        }

        .info-label {
            font-weight: bold;
        }

        .info-value {
            font-weight: bold;
            letter-spacing: 0.1px;
        }

        /* Examination Title */
        .examination-title {
            font-size: 14px;
            font-weight: bold;
            margin: 5mm 0 3mm 0;
            text-align: center;
            padding: 6px;
            background: #fff;
            border-left: 2px solid #000;
        }

        /* Marks Table */
        .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5mm;
            font-size: 9px;
        }

        .marks-table th {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            background: #fff;
        }

        .marks-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .marks-table td.course-code {
            width: 12%;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        .marks-table td.course-title {
            width: 58%;
            text-align: left;
        }

        .marks-table td.credits,
        .marks-table td.gp,
        .marks-table td.grade {
            width: 10%;
        }

        /* Summary Section */
        .summary-section {
            margin-bottom: 5mm;
            padding: 10px;
            background: #fff;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .summary-left {
            color: #000;
        }

        .summary-right {
            color: #000;
            font-size: 12px;
        }

        /* Signatures */
        .signatures {
            margin-top: 10mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 10px;
        }

        .signature-block {
            text-align: center;
            flex: 1;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            height: 20px;
            margin-bottom: 3px;
        }

        .signature-label {
            font-size: 9px;
            font-weight: bold;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* Print Date */
        .print-date {
            text-align: right;
            margin-top: 5mm;
            font-size: 8px;
            font-style: italic;
        }

        /* Print Media */
        @media print {
            body {
                font-size: 9px;
                margin: 0;
            }

            .container {
                width: 100%;
                margin: 0;
                padding: 0;
            }

            .header {
                margin-bottom: 5mm;
            }

            .transcript-header {
                margin-bottom: 5mm;
            }

            .info-table {
                margin-bottom: 3mm;
            }

            .examination-title {
                margin: 3mm 0 2mm 0;
            }

            .marks-table {
                margin-bottom: 3mm;
            }

            .summary-section {
                margin-bottom: 3mm;
            }

            .signatures {
                margin-top: 8mm;
            }

            .print-date {
                margin-top: 2mm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            <!-- University Logo -->
            <div class="logo">
                @if(file_exists(public_path('images/nstu-logo.png')))
                    <img src="{{ public_path('images/nstu-logo.png') }}" alt="NSTU Logo">
                @else
                    <div class="logo-placeholder">
                        NSTU<br>LOGO
                    </div>
                @endif
            </div>

            <!-- University Information -->
            <div class="university-info">
                <div class="university-name">Noakhali Science and Technology University</div>
                <div class="university-address">Noakhali - 3814, Bangladesh</div>
            </div>

            <!-- Contact Information -->
            <div class="contact-info">
                TEL: 0321-62812<br>
                FAX: 0321-62788<br>
                <span class="web">www.nstu.edu.bd</span>
            </div>
        </div>

        <!-- Transcript Header -->
        <div class="transcript-header">Academic Transcript</div>

        <!-- Student Information and Grading Scheme Table -->
        <table class="info-table">
            <tr>
                <td class="dept-title" colspan="10">
                    <span style="font-weight: bold;">Department of Information and Communication Engineering</span>
                </td>
            </tr>
            <tr>
                <td class="student-info-left" rowspan="3" colspan="5">
                    Bachelor of Science (Engg.)<br><br>
                    Session: {{ $marksheet->session ?? 'N/A' }}
                </td>
                <td class="grading-scheme-vertical" rowspan="6">
                    GRADING SCHEME
                </td>
                <td class="grading-table-container" rowspan="6" colspan="4" style="padding:0;">
                    <table class="grading-table">
                        <tr>
                            <th>Range</th>
                            <th>Grade Point</th>
                            <th>Grade</th>
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
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
            <tr>
                <td class="student-info-left" rowspan="3" colspan="5">
                    <span class="info-label">Student name:</span> <span class="info-value">{{ $marksheet->student->name ?? 'N/A' }}</span><br><br>
                    <span class="info-label">Student ID:</span> <span class="info-value">{{ $marksheet->student->studentid ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr></tr>
            <tr></tr>
        </table>

        <!-- Examination Title -->
        <div class="examination-title">
            {{ $marksheet->academicYear->name ?? 'N/A' }} Year - {{ $marksheet->term->name ?? 'N/A' }} Term Examination
        </div>

        <!-- Marks Table -->
        <table class="marks-table">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Course Title</th>
                    <th>Credits</th>
                    <th>GP</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $mark)
                    <tr>
                        <td class="course-code">{{ $mark->course->code }}</td>
                        <td class="course-title">{{ $mark->course->name }}</td>
                        <td class="credits">{{ number_format($mark->course->credits, 2) }}</td>
                        <td class="gp">{{ number_format($mark->grade_point, 2) }}</td>
                        <td class="grade">{{ $mark->grade }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-row" style="display: flex; justify-content: space-between;">
                <div class="summary-left">Credits Completed: {{ $marksheet->credits_completed }} out of {{ $marksheet->total_credits }}</div>
                <div class="summary-right">Term GPA (TGPA): {{ number_format($marksheet->tgpa, 2) }}</div>
            </div>
            <div class="summary-row" style="display: flex; justify-content: space-between;">
                <div class="summary-left">Cumulative Credits: {{ $marksheet->cumulative_credits }} out of {{ $marksheet->total_cumulative_credits }}</div>
                <div class="summary-right">Cumulative GPA (CGPA): {{ number_format($marksheet->cgpa, 2) }}</div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Prepared by</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="signature-label">Compared by</div>
            </div>
            <div class="signature-block">
                <div class="signature-line"></div>
                <div class="summary-label">Controller of Examinations</div>
            </div>
        </div>

        <!-- Print Date -->
        <div class="print-date">
            Printed on: {{ now()->format('d/m/Y') }}
        </div>
    </div>
</body>
</html>