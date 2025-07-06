@extends('layouts.teacher')

@section('title', 'Course Students')

@section('page-title', 'Students Enrolled in ' . $course->course_code)

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $course->title }} ({{ $course->course_code }})</h5>
                    <div>
                        <span class="badge bg-light text-dark me-2">{{ $academicYear }}</span>
                        <span class="badge bg-light text-dark">{{ $term }}</span>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Course Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Course Details</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Course Code:</th>
                                        <td>{{ $course->course_code }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course Title:</th>
                                        <td>{{ $course->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Credits:</th>
                                        <td>{{ number_format($course->credits, 1) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Department:</th>
                                        <td>{{ $course->department }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Mark Distribution</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="40%">Attendance:</th>
                                        <td>10 marks</td>
                                    </tr>
                                    <tr>
                                        <th>Class Tests:</th>
                                        <td>15 marks</td>
                                    </tr>
                                    <tr>
                                        <th>Mid Term:</th>
                                        <td>25 marks</td>
                                    </tr>
                                    <tr>
                                        <th>Final:</th>
                                        <td>40 marks</td>
                                    </tr>
                                    <tr>
                                        <th>Viva:</th>
                                        <td>10 marks</td>
                                    </tr>
                                    <tr class="table-primary">
                                        <th>Total:</th>
                                        <td>100 marks</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Mark Status</th>
                                <th>Grade</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $student->studentid }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        <td>
                                                            @if($student->has_result)
                                                                <span class="badge bg-success">Marks Entered</span>
                                                            @else
                                                                <span class="badge bg-warning">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($student->has_result)
                                                                <span class="badge bg-{{ $student->result->letter_grade == 'F' ? 'danger' : 'info' }}">
                                                                    {{ $student->result->letter_grade }}
                                                                    ({{ number_format($student->result->grade_point, 2) }})
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('teacher.createMarkEntry', [
                                    'course' => $course->id,
                                    'student' => $student->id,
                                    'year' => $academicYear,
                                    'term' => $term
                                ]) }}"
                                                                class="btn btn-sm {{ $student->has_result ? 'btn-warning' : 'btn-primary' }}">
                                                                <i class="fas {{ $student->has_result ? 'fa-edit' : 'fa-plus' }} me-1"></i>
                                                                {{ $student->has_result ? 'Edit Marks' : 'Enter Marks' }}
                                                            </a>

                                                            @if($student->has_result)
                                                                <a href="{{ route('teacher.previewResult', $student->result->id) }}"
                                                                    class="btn btn-info btn-sm" target="_blank">
                                                                    <i class="fas fa-eye me-1"></i> View PDF
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No students enrolled in this course for the selected
                                        term.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Back Button -->
                <div class="mt-3">
                    <a href="{{ route('teacher.courses') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Courses
                    </a>

                    <!-- Export Button (optional feature) -->
                    <button class="btn btn-success float-end">
                        <i class="fas fa-file-excel me-1"></i> Export to Excel
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection