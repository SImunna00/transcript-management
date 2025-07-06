@extends('layouts.teacher')

@section('title', 'Dashboard')

@section('page-title', 'Teacher Dashboard')

@section('content')
    <div class="container-fluid">
        <!-- Stats Cards - Display key metrics for teachers -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-book text-primary"></i>
                    <h3>{{ $stats['total_courses'] }}</h3>
                    <p>Total Assigned Courses</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-calendar-alt text-success"></i>
                    <h3>{{ $stats['current_courses'] }}</h3>
                    <p>Current Year Courses</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-users text-info"></i>
                    <h3>{{ $stats['total_students'] }}</h3>
                    <p>Total Students</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="fas fa-tasks text-warning"></i>
                    <h3>{{ $stats['pending_marks'] }}</h3>
                    <p>Pending Approvals</p>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards - Direct links to common actions -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('teacher.courses') }}" class="btn btn-outline-primary">
                                <i class="fas fa-book me-2"></i> View My Courses
                            </a>
                            <a href="{{ route('teacher.results') }}" class="btn btn-outline-success">
                                <i class="fas fa-chart-bar me-2"></i> View All Results
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Academic Calendar</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mid-term Exams
                                <span class="badge bg-primary rounded-pill">15 Jul - 30 Jul</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Final Exams
                                <span class="badge bg-primary rounded-pill">15 Aug - 30 Aug</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Result Submission
                                <span class="badge bg-danger rounded-pill">15 Sep</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Results Table - Shows the most recent submissions -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Recent Results Submitted</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Year/Term</th>
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_results as $result)
                                <tr>
                                    <td>
                                        {{ $result->user->name }}
                                        <br>
                                        <small class="text-muted">{{ $result->user->studentid }}</small>
                                    </td>
                                    <td>
                                        {{ $result->course->title }}
                                        <br>
                                        <small class="text-muted">{{ $result->course->course_code }}</small>
                                    </td>
                                    <td>{{ $result->academic_year }}/{{ $result->term }}</td>
                                    <td>{{ number_format($result->total_marks, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $result->letter_grade == 'F' ? 'danger' : 'success' }}">
                                            {{ $result->letter_grade }} ({{ number_format($result->grade_point, 2) }})
                                        </span>
                                    </td>
                                    <td>
                                        @if($result->approved)
                                            <span class="badge bg-success">Approved</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $result->created_at->format('d M, Y') }}</td>
                                    <td>
                                        <a href="{{ route('teacher.previewResult', $result->id) }}" class="btn btn-sm btn-info"
                                            target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No results submitted yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="{{ route('teacher.results') }}" class="btn btn-primary">View All Results</a>
                </div>
            </div>
        </div>
    </div>
@endsection