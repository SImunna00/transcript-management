@extends('layouts.teacher')

@section('title', 'Marksheet Template')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Generate Marksheet</h5>
            </div>
            <div class="card-body">
                <form id="marksheetForm" action="{{ route('teacher.generate-marksheet') }}" method="GET" target="_blank">
                    <!-- Using ICE department by default - hidden field -->
                    <input type="hidden" name="department_id" value="1">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="session" class="form-label">Session</label>
                            <select class="form-select" id="session" name="session" required>
                                <option value="">Select Session</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="semester" class="form-label">Semester</label>
                            <select class="form-select" id="semester" name="semester_id" required disabled>
                                <option value="">Select Semester</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="student" class="form-label">Student</label>
                            <select class="form-select" id="student" name="student_id" required disabled>
                                <option value="">Select Student</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" disabled id="generateBtn">
                            <i class="fas fa-file-pdf me-2"></i> Generate PDF
                        </button>
                        <button type="button" class="btn btn-success ms-2" disabled id="viewCgpaBtn">
                            <i class="fas fa-chart-bar me-2"></i> View CGPA
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sessionSelect = document.getElementById('session');
            const semesterSelect = document.getElementById('semester');
            const studentSelect = document.getElementById('student');
            const generateBtn = document.getElementById('generateBtn');
            const viewCgpaBtn = document.getElementById('viewCgpaBtn');

            // CGPA button click handler
            viewCgpaBtn.addEventListener('click', function () {
                const studentId = studentSelect.value;
                if (studentId) {
                    window.open(`{{ url('teacher/view-cgpa') }}/${studentId}`, '_blank');
                }
            });

            // Fetch semesters for ICE department (assuming id=1) on page load
            fetch(`{{ route('teacher.get-semesters') }}?department_id=1`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    semesterSelect.innerHTML = '<option value="">Select Semester</option>';

                    // Add new options
                    data.forEach(semester => {
                        const option = document.createElement('option');
                        option.value = semester.id;
                        option.textContent = semester.name;
                        semesterSelect.appendChild(option);
                    });
                });

            // Session change
            sessionSelect.addEventListener('change', function () {
                if (this.value) {
                    // Enable semester select
                    semesterSelect.disabled = false;

                    // Reset dependent fields
                    studentSelect.value = '';
                    studentSelect.disabled = true;
                    generateBtn.disabled = true;
                    viewCgpaBtn.disabled = true;
                } else {
                    // Disable dependent selects
                    semesterSelect.disabled = true;
                    studentSelect.disabled = true;
                    generateBtn.disabled = true;
                    viewCgpaBtn.disabled = true;
                }
            });            // Semester change
            semesterSelect.addEventListener('change', function () {
                if (this.value) {
                    // Fetch students for the selected session (no department filter needed)
                    fetch(`{{ route('teacher.get-students') }}?session=${sessionSelect.value}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear existing options
                            studentSelect.innerHTML = '<option value="">Select Student</option>';

                            // Add new options
                            data.forEach(student => {
                                const option = document.createElement('option');
                                option.value = student.id;
                                option.textContent = `${student.studentid} - ${student.name}`;
                                studentSelect.appendChild(option);
                            });

                            // Enable student select
                            studentSelect.disabled = false;
                        });
                } else {
                    // Disable dependent selects
                    studentSelect.disabled = true;
                    generateBtn.disabled = true;
                    viewCgpaBtn.disabled = true;
                }
            });

            // Student change
            studentSelect.addEventListener('change', function () {
                // Enable buttons if student is selected
                const isStudentSelected = !!this.value;
                generateBtn.disabled = !isStudentSelected;
                viewCgpaBtn.disabled = !isStudentSelected;
            });
        });
    </script>
@endpush