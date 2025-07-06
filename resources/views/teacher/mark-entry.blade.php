@extends('layouts.teacher')

@section('title', 'Enter Marks')

@section('page-title', 'Mark Entry Form')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    {{ $course->course_code }} - {{ $course->title }}
                    ({{ $academicYear }}, {{ $term }})
                </h5>
            </div>
            <div class="card-body">
                <!-- Student Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Student Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Student ID:</th>
                                        <td>{{ $student->studentid }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name:</th>
                                        <td>{{ $student->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Course Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Course Code:</th>
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mark Entry Form -->
                <form action="{{ route('teacher.storeMarkEntry', [
        'course' => $course->id,
        'student' => $student->id
    ]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="academic_year" value="{{ $academicYear }}">
                    <input type="hidden" name="term" value="{{ $term }}">

                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Enter Marks</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="attendance" class="form-label">Attendance (Max: 10)</label>
                                        <div class="input-group">
                                            <input type="number" id="attendance" name="attendance"
                                                class="form-control @error('attendance') is-invalid @enderror" min="0"
                                                max="10" step="0.1" required
                                                value="{{ old('attendance', $result->attendance ?? 0) }}">
                                            <span class="input-group-text">/10</span>
                                        </div>
                                        @error('attendance')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="class_test" class="form-label">Class Tests (Max: 15)</label>
                                        <div class="input-group">
                                            <input type="number" id="class_test" name="class_test"
                                                class="form-control @error('class_test') is-invalid @enderror" min="0"
                                                max="15" step="0.1" required
                                                value="{{ old('class_test', $result->class_test ?? 0) }}">
                                            <span class="input-group-text">/15</span>
                                        </div>
                                        @error('class_test')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mid_term" class="form-label">Mid Term (Max: 25)</label>
                                        <div class="input-group">
                                            <input type="number" id="mid_term" name="mid_term"
                                                class="form-control @error('mid_term') is-invalid @enderror" min="0"
                                                max="25" step="0.1" required
                                                value="{{ old('mid_term', $result->mid_term ?? 0) }}">
                                            <span class="input-group-text">/25</span>
                                        </div>
                                        @error('mid_term')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="final" class="form-label">Final Exam (Max: 40)</label>
                                        <div class="input-group">
                                            <input type="number" id="final" name="final"
                                                class="form-control @error('final') is-invalid @enderror" min="0" max="40"
                                                step="0.1" required value="{{ old('final', $result->final ?? 0) }}">
                                            <span class="input-group-text">/40</span>
                                        </div>
                                        @error('final')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="viva" class="form-label">Viva (Max: 10)</label>
                                        <div class="input-group">
                                            <input type="number" id="viva" name="viva"
                                                class="form-control @error('viva') is-invalid @enderror" min="0" max="10"
                                                step="0.1" required value="{{ old('viva', $result->viva ?? 0) }}">
                                            <span class="input-group-text">/10</span>
                                        </div>
                                        @error('viva')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total" class="form-label">Total Marks</label>
                                        <div class="input-group">
                                            <input type="text" id="total" class="form-control" readonly
                                                value="{{ old('total', $result->total_marks ?? 0) }}">
                                            <span class="input-group-text">/100</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Grading Scale Reference -->
                            <div class="mt-4">
                                <h6>Grading Scale Reference:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Marks Range</th>
                                                <th>Letter Grade</th>
                                                <th>Grade Point</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>80-100</td>
                                                <td>A+</td>
                                                <td>4.00</td>
                                            </tr>
                                            <tr>
                                                <td>75-79</td>
                                                <td>A</td>
                                                <td>3.75</td>
                                            </tr>
                                            <tr>
                                                <td>70-74</td>
                                                <td>A-</td>
                                                <td>3.50</td>
                                            </tr>
                                            <tr>
                                                <td>65-69</td>
                                                <td>B+</td>
                                                <td>3.25</td>
                                            </tr>
                                            <tr>
                                                <td>60-64</td>
                                                <td>B</td>
                                                <td>3.00</td>
                                            </tr>
                                            <tr>
                                                <td>55-59</td>
                                                <td>B-</td>
                                                <td>2.75</td>
                                            </tr>
                                            <tr>
                                                <td>50-54</td>
                                                <td>C+</td>
                                                <td>2.50</td>
                                            </tr>
                                            <tr>
                                                <td>45-49</td>
                                                <td>C</td>
                                                <td>2.25</td>
                                            </tr>
                                            <tr>
                                                <td>40-44</td>
                                                <td>D</td>
                                                <td>2.00</td>
                                            </tr>
                                            <tr>
                                                <td>0-39</td>
                                                <td>F</td>
                                                <td>0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('teacher.courseStudents', [
        'course' => $course->id,
        'year' => $academicYear,
        'term' => $term
    ]) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </a>
                                <div>
                                    <button type="reset" class="btn btn-warning">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> {{ $result ? 'Update' : 'Submit' }} Marks
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Calculate total marks automatically
        document.addEventListener('DOMContentLoaded', function () {
            const attendanceInput = document.getElementById('attendance');
            const classTestInput = document.getElementById('class_test');
            const midTermInput = document.getElementById('mid_term');
            const finalInput = document.getElementById('final');
            const vivaInput = document.getElementById('viva');
            const totalInput = document.getElementById('total');

            const calculateTotal = function () {
                const attendance = parseFloat(attendanceInput.value) || 0;
                const classTest = parseFloat(classTestInput.value) || 0;
                const midTerm = parseFloat(midTermInput.value) || 0;
                const final = parseFloat(finalInput.value) || 0;
                const viva = parseFloat(vivaInput.value) || 0;

                const total = attendance + classTest + midTerm + final + viva;
                totalInput.value = total.toFixed(2);
            };

            // Calculate on page load
            calculateTotal();

            // Calculate when any input changes
            [attendanceInput, classTestInput, midTermInput, finalInput, vivaInput].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });
        });
    </script>
@endpush