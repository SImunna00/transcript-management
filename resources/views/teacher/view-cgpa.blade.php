@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Student CGPA Details</span>
                            <a href="{{ route('teacher.dashboard') }}" class="btn btn-sm btn-secondary">Back to
                                Dashboard</a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        Student Information
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">Name:</th>
                                                <td>{{ $student->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Student ID:</th>
                                                <td>{{ $student->studentid }}</td>
                                            </tr>
                                            <tr>
                                                <th>Session:</th>
                                                <td>{{ $student->session }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        CGPA Information
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="60%">CGPA:</th>
                                                <td><strong>{{ number_format($transcript->cgpa, 2) }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Total Credits Completed:</th>
                                                <td>{{ $transcript->total_credits_completed }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    <span
                                                        class="badge {{ $transcript->status === 'completed' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ ucfirst($transcript->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header bg-info text-white">
                                Semester-wise Results
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-dark">
                                            <th>#</th>
                                            <th>Semester</th>
                                            <th>Session</th>
                                            <th>Credits</th>
                                            <th>GPA</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($semesterResults as $key => $result)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $result->semester->name }}</td>
                                                                                <td>{{ $result->session }}</td>
                                                                                <td>{{ $result->total_credits }}</td>
                                                                                <td>{{ number_format($result->gpa, 2) }}</td>
                                                                                <td>
                                                                                    <a href="{{ route('teacher.generate-marksheet', [
                                                'student_id' => $student->id,
                                                'semester_id' => $result->semester_id,
                                                'session' => $result->session
                                            ]) }}" class="btn btn-sm btn-primary" target="_blank">
                                                                                        <i class="fas fa-file-pdf"></i> View Marksheet
                                                                                    </a>
                                                                                </td>
                                                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle"></i> CGPA is calculated using the formula: <br>
                            <code>CGPA = sum(TGPA × credits of term) / sum(total credits of completed terms)</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection