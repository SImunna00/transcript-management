@extends('layouts.teacher')

@section('title', 'All Results')

@section('page-title', 'Results Management')

@section('content')
    <div class="container-fluid">
        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Filter Results</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.results') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label for="year" class="form-label">Academic Year</label>
                        <select name="year" id="year" class="form-select">
                            <option value="">All Years</option>
                            @foreach($academicYears as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="term" class="form-label">Term</label>
                        <select name="term" id="term" class="form-select">
                            <option value="">All Terms</option>
                            @foreach($terms as $term)
                                <option value="{{ $term }}" {{ request('term') == $term ? 'selected' : '' }}>
                                    {{ $term }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="course" class="form-label">Course</label>
                        <select name="course" id="course" class="form-select">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_code }} - {{ $course->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Results Table -->
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Results List</h5>
                    <span class="badge bg-light text-dark">{{ $results->total() }} records</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Year/Term</th>
                                <th>Marks</th>
                                <th>Grade</th>
                                <th>Status</th>
                                <th>Submitted On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $result)
                                                    <tr>
                                                        <td>{{ $result->id }}</td>
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
                                                        <td>
                                                            <small>
                                                                A: {{ $result->attendance }}, CT: {{ $result->class_test }},
                                                                <br>
                                                                MT: {{ $result->mid_term }}, F: {{ $result->final }},
                                                                V: {{ $result->viva }}
                                                            </small>
                                                            <br>
                                                            <strong>Total: {{ number_format($result->total_marks, 2) }}</strong>
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-{{ $result->letter_grade == 'F' ? 'danger' : 'success' }}">
                                                                {{ $result->letter_grade }} ({{ number_format($result->grade_point, 2) }})
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($result->approved)
                                                                <span class="badge bg-success">Approved</span>
                                                                @if($result->approved_at)
                                                                    <br>
                                                                    <small>{{ $result->approved_at->format('d M, Y') }}</small>
                                                                @endif
                                                            @else
                                                                <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $result->created_at->format('d M, Y') }}</td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="{{ route('teacher.previewResult', $result->id) }}"
                                                                    class="btn btn-info btn-sm" target="_blank">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('teacher.createMarkEntry', [
                                    'course' => $result->course_id,
                                    'student' => $result->user_id,
                                    'year' => $result->academic_year,
                                    'term' => $result->term
                                ]) }}" class="btn btn-warning btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No results found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection