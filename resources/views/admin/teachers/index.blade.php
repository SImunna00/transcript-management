@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>All Teachers</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->id }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->department }}</td>
                <td>{{ $teacher->phone }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection