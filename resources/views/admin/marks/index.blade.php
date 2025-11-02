@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>All Marks</h1>

    <h2>Theory Marks</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Session</th>
                <th>Participation</th>
                <th>CT</th>
                <th>Semester Final</th>
                <th>Total</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach($theoryMarks as $mark)
            <tr>
                <td>{{ $mark->user->name ?? 'N/A' }}</td>
                <td>{{ $mark->course->name ?? 'N/A' }}</td>
                <td>{{ $mark->session }}</td>
                <td>{{ $mark->participation }}</td>
                <td>{{ $mark->ct }}</td>
                <td>{{ $mark->semester_final }}</td>
                <td>{{ $mark->total }}</td>
                <td>{{ $mark->grade }}</td>
                <td>{{ $mark->grade_point }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Lab Marks</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Session</th>
                <th>Attendance</th>
                <th>Report</th>
                <th>Lab Work</th>
                <th>Viva</th>
                <th>Total</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labMarks as $mark)
            <tr>
                <td>{{ $mark->user->name ?? 'N/A' }}</td>
                <td>{{ $mark->course->name ?? 'N/A' }}</td>
                <td>{{ $mark->session }}</td>
                <td>{{ $mark->attendance }}</td>
                <td>{{ $mark->report }}</td>
                <td>{{ $mark->lab_work }}</td>
                <td>{{ $mark->viva }}</td>
                <td>{{ $mark->total }}</td>
                <td>{{ $mark->grade }}</td>
                <td>{{ $mark->grade_point }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Special Marks</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Course</th>
                <th>Session</th>
                <th>Full Marks</th>
                <th>Grade</th>
                <th>Grade Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach($specialMarks as $mark)
            <tr>
                <td>{{ $mark->user->name ?? 'N/A' }}</td>
                <td>{{ $mark->course->name ?? 'N/A' }}</td>
                <td>{{ $mark->session }}</td>
                <td>{{ $mark->full_marks }}</td>
                <td>{{ $mark->grade }}</td>
                <td>{{ $mark->grade_point }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection