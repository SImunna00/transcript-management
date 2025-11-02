@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>All Courses</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Credits</th>
                <th>Academic Year</th>
                <th>Term</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->code }}</td>
                <td>{{ $course->name }}</td>
                <td>{{ $course->credits }}</td>
                <td>{{ $course->academicYear->name ?? 'N/A' }}</td>
                <td>{{ $course->term->name ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection