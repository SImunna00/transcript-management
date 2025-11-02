<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Testimonial</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 0;
            font-size: 12pt;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .university-logo {
            width: 80px;
            height: auto;
            margin: 0 auto;
        }

        .university-name {
            font-size: 18pt;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        .address {
            font-size: 12pt;
            margin-bottom: 5px;
        }

        .document-title {
            font-size: 16pt;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 20px;
            text-decoration: underline;
        }

        .content {
            text-align: justify;
            margin-bottom: 20px;
            font-size: 12pt;
            line-height: 1.8;
        }

        .ref-number {
            font-size: 11pt;
            margin-bottom: 30px;
        }

        .date {
            font-size: 11pt;
            margin-bottom: 30px;
            text-align: right;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
            margin-left: auto;
            text-align: center;
        }

        .signature-name {
            margin-top: 5px;
            font-weight: bold;
        }

        .signature-title {
            font-size: 11pt;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10pt;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="university-name">Noakhali Science and Technology University</div>
            <div class="address">Noakhali-3814, Bangladesh</div>
            <div class="document-title">TESTIMONIAL</div>
        </div>

        <div class="ref-number">
            Ref: NSTU/ICE/Testimonial/{{ date('Y') }}/{{ $documentRequest->id }}
        </div>

        <div class="date">
            Date: {{ date('F d, Y') }}
        </div>

        <div class="content">
            <p>This is to certify that <strong>{{ $student->name }}</strong>, bearing Student ID
                <strong>{{ $student->studentid }}</strong>, son/daughter of <strong>{{ $student->father_name }}</strong>
                and <strong>{{ $student->mother_name }}</strong>, was a bonafide student of the Department of
                Information and Communication Engineering, Noakhali Science and Technology University in the session
                <strong>{{ $student->session }}</strong>.</p>

            <p>During his/her study period, he/she has successfully completed all the required courses for the degree of
                <strong>Bachelor of Science (B.Sc.) in Information and Communication Engineering</strong> with a
                Cumulative Grade Point Average (CGPA) of <strong>{{ number_format($cgpa, 2) }}</strong> out of 4.00.</p>

            <p>To the best of my knowledge, he/she maintained good conduct and character throughout his/her stay in this
                university. He/She did not take part in any activity subversive to the state or of discipline.</p>

            <p>I wish him/her every success in life.</p>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <div class="signature-name">Prof. Dr. Mohammad Abdullah</div>
            <div class="signature-title">Chairman</div>
            <div class="signature-title">Department of Information and Communication Engineering</div>
            <div class="signature-title">Noakhali Science and Technology University</div>
        </div>

        <div class="footer">
            <p>This document is computer generated based on an approved request. Verification can be done through the
                university portal.</p>
            <p>Document ID: {{ $documentRequest->id }} | Generated on: {{ date('F d, Y') }}</p>
            <p>Purpose: {{ $documentRequest->purpose }}</p>
        </div>
    </div>
</body>

</html>