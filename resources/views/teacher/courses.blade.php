@extends('layouts.teacher')

@section('title', 'My Courses')

@section('page-title', 'My Assigned Courses')

@section('content')
    <div class="container-fluid">
        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filter Courses</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.courses') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label for="year" class="form-label">Academic Year</label>
                        <select name="year" id="year" class="form-select">
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="term" class="form-label">Term</label>
                        <select name="term" id="term" class="form-select">
                            @foreach($terms as $term)
                                <option value="{{ $term }}" {{ $term == $selectedTerm ? 'selected' : '' }}>
                                    {{ $term }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Courses List -->
        <div class="card">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Courses for {{ $selectedYear }}, {{ $selectedTerm }}</h5>
                <span class="badge bg-light text-dark">{{ $courses->count() }} courses</span>
            </div>
            <div class="card-body">
                @if($courses->isEmpty())
                    <div class="alert alert-info">
                        No courses assigned for the selected academic year and term.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Course Code</th>
                                    <th>Course Title</th>
                                    <th>Credits</th>
                                    <th>Department</th>
                                    <th>Students Enrolled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td>{{ $course->course_code }}</td>
                                        <td>{{ $course->title }}</td>
                                        <td>{{ number_format($course->credits, 1) }}</td>
                                        <td>{{ $course->department }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $course->students_count }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('teacher.courseStudents', ['course' => $course->id, 'year' => $selectedYear, 'term' => $selectedTerm]) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-users me-1"></i> View Students
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection