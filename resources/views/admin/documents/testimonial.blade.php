<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonial</title>
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

        .testimonial-content {
            text-align: justify;
            line-height: 1.6;
            margin: 30px 0;
            font-size: 14px;
        }

        .reference-number {
            font-size: 12px;
            margin-top: 40px;
        }

        .date {
            font-size: 12px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
        }

        .signature-line {
            margin-top: 50px;
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            padding-top: 5px;
            font-weight: bold;
            float: right;
            margin-right: 50px;
        }
    </style>
</head>

<body>
    <div class="header">
        <!-- University Logo would go here -->
        <div class="university-name">Noakhali Science and Technology University</div>
        <div class="department-name">Department of Information & Communication Engineering</div>
        <div class="document-title">TESTIMONIAL</div>
    </div>

    <div class="testimonial-content">
        <p>
            This is to certify that <strong>{{ $student->name }}</strong>, Son/Daughter of
            <strong>{{ $student->father_name }}</strong> and <strong>{{ $student->mother_name }}</strong>,
            having Student ID <strong>{{ $student->studentid }}</strong>, was a bonafide student of the Department of
            Information & Communication Engineering,
            Noakhali Science and Technology University during the session <strong>{{ $student->session }}</strong>.
        </p>

        <p>
            He/She has successfully completed the B.Sc. Engineering program in Information & Communication Engineering
            @if($finalResult)
                with a CGPA of <strong>{{ $finalResult->cgpa }}</strong> out of 4.00
            @endif
            from this University.
        </p>

        <p>
            During his/her stay in the University, his/her conduct and character were found to be <strong>GOOD</strong>
            and to the best of my knowledge, he/she did not participate in any activity subversive to the state or
            discipline.
        </p>

        <p>
            I wish him/her every success in life.
        </p>
    </div>

    <div class="reference-number">
        Reference No: NSTU/ICE/TEST/{{ date('Y') }}/{{ $documentRequest->id }}
    </div>

    <div class="date">
        Date: {{ date('F d, Y') }}
    </div>

    <div class="footer">
        <div class="signature-line">Head of Department</div>
    </div>
</body>

</html>