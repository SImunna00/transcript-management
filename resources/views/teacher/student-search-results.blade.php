@extends('layouts.teacher')

@section('title', 'Student Search Results')

@section('page-title', 'Student Search Results')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Search Results: "{{ $search }}" (Session: {{ $session }})</h5>
                            <a href="{{ route('teacher.mark.entry') }}" class="btn btn-sm btn-light">
                                <i class="fas fa-search me-1"></i> New Search
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($students->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No students found matching your search criteria.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Student ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Session</th>
                                            <th>Department</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $student)
                                            <tr>
                                                <td>{{ $student->studentid }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->session }}</td>
                                                <td>{{ $student->department ? $student->department->name : 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('teacher.mark.student', $student->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit me-1"></i> Enter/Edit Marks
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
        </div>
    </div>
@endsection