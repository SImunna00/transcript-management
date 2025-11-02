@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Analytics Report</h1>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Students</div>
                <div class="card-body">{{ $totalStudents }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Teachers</div>
                <div class="card-body">{{ $totalTeachers }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Courses</div>
                <div class="card-body">{{ $totalCourses }}</div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Total Transcript Requests</div>
                <div class="card-body">{{ $totalTranscriptRequests }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Pending Transcript Requests</div>
                <div class="card-body">{{ $pendingTranscriptRequests }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Completed Transcript Requests</div>
                <div class="card-body">{{ $completedTranscriptRequests }}</div>
            </div>
        </div>
    </div>
</div>
@endsection