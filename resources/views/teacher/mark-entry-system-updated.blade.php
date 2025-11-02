@extends('layouts.teacher')

@section('title', 'Mark Entry System')

@section('page-title', 'Mark Entry System')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Enter Marks</h5>
            </div>
            <div class="card-body">
                <!-- Step 1: Select Department, Academic Year, and Semester -->
                <div id="step1" class="border-bottom pb-4 mb-4">
                    <h6 class="card-subtitle mb-3 text-muted">Step 1: Select Course Information</h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="department" class="form-label">Department</label>
                            <select id="department" name="department" class="form-select">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="academicYear" class="form-label">Academic Year</label>
                            <select id="academicYear" name="academicYear" class="form-select">
                                <option value="">Select Academic Year</option>
                                @foreach($academicYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="semester" class="form-label">Semester</label>
                            <select id="semester" name="semester" class="form-select" disabled>
                                <option value="">Select Semester</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="button" id="step1Next" class="btn btn-primary" disabled>Next Step</button>
                    </div>
                </div>

                <!-- Step 2: Select Course and Session -->
                <div id="step2" class="border-bottom pb-4 mb-4 d-none">
                    <h6 class="card-subtitle mb-3 text-muted">Step 2: Select Course and Session</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <select id="course" name="course" class="form-select">
                                <option value="">Select Course</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="session" class="form-label">Student Session</label>
                            <input type="text" id="session" name="session" class="form-control" 
                                placeholder="e.g. 2022-23">
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" id="step2Back" class="btn btn-secondary">Back</button>
                        <button type="button" id="step2Next" class="btn btn-primary" disabled>Next Step</button>
                    </div>
                </div>

                <!-- Step 3: Enter Marks for Students -->
                <div id="step3" class="d-none">
                    <h6 class="card-subtitle mb-3 text-muted">Step 3: Enter Student Marks</h6>

                    <div id="courseInfo" class="bg-light p-3 rounded mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1">Course Code: <span id="displayCourseCode" class="fw-bold"></span></p>
                                <p class="mb-1">Course Title: <span id="displayCourseTitle" class="fw-bold"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1">Credit Hours: <span id="displayCreditHours" class="fw-bold"></span></p>
                                <p class="mb-1">Course Type: <span id="displayCourseType" class="fw-bold"></span></p>
                            </div>
                        </div>
                    </div>

                    <div id="marksTableContainer" class="mt-4 table-responsive">
                        <!-- Table will be dynamically populated -->
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="button" id="step3Back" class="btn btn-secondary">Back</button>
                        <button type="button" id="saveMarks" class="btn btn-success">Save Marks</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Step 1: Department and Semester Selection
            const departmentSelect = document.getElementById('department');
            const academicYearSelect = document.getElementById('academicYear');
            const semesterSelect = document.getElementById('semester');
            const step1NextButton = document.getElementById('step1Next');

            // Step 2: Course and Session Selection
            const courseSelect = document.getElementById('course');
            const sessionInput = document.getElementById('session');
            const step2NextButton = document.getElementById('step2Next');

            // Navigation Buttons
            const step2BackButton = document.getElementById('step2Back');
            const step3BackButton = document.getElementById('step3Back');
            const saveMarksButton = document.getElementById('saveMarks');

            // Step Containers
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');

            // Fetch semesters when department is selected
            departmentSelect.addEventListener('change', function () {
                if (this.value) {
                    // Enable semester select
                    semesterSelect.disabled = false;

                    // Fetch semesters for the selected department
                    fetch(`/teacher/get-semesters?department_id=${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear previous options
                            semesterSelect.innerHTML = '<option value="">Select Semester</option>';

                            // Add new options
                            data.forEach(semester => {
                                const option = document.createElement('option');
                                option.value = semester.id;
                                option.textContent = `${semester.name} (Year ${semester.year}, Term ${semester.term})`;
                                semesterSelect.appendChild(option);
                            });
                        });
                } else {
                    semesterSelect.disabled = true;
                    semesterSelect.innerHTML = '<option value="">Select Semester</option>';
                }

                checkStep1Completion();
            });

            // Check if step 1 is complete
            function checkStep1Completion() {
                if (departmentSelect.value && academicYearSelect.value && semesterSelect.value) {
                    step1NextButton.disabled = false;
                } else {
                    step1NextButton.disabled = true;
                }
            }

            // Event listeners for step 1 completion check
            academicYearSelect.addEventListener('change', checkStep1Completion);
            semesterSelect.addEventListener('change', checkStep1Completion);

            // Move to step 2
            step1NextButton.addEventListener('click', function () {
                step1.classList.add('d-none');
                step2.classList.remove('d-none');

                // Fetch courses for the selected semester
                fetch(`/teacher/get-courses?semester_id=${semesterSelect.value}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous options
                        courseSelect.innerHTML = '<option value="">Select Course</option>';

                        // Add new options
                        data.forEach(course => {
                            const option = document.createElement('option');
                            option.value = course.id;
                            option.textContent = `${course.code} - ${course.title}`;
                            courseSelect.appendChild(option);
                        });
                    });
            });

            // Check if step 2 is complete
            function checkStep2Completion() {
                if (courseSelect.value && sessionInput.value) {
                    step2NextButton.disabled = false;
                } else {
                    step2NextButton.disabled = true;
                }
            }

            // Event listeners for step 2 completion check
            courseSelect.addEventListener('change', checkStep2Completion);
            sessionInput.addEventListener('input', checkStep2Completion);

            // Back to step 1
            step2BackButton.addEventListener('click', function () {
                step2.classList.add('d-none');
                step1.classList.remove('d-none');
            });

            // Move to step 3
            step2NextButton.addEventListener('click', function () {
                step2.classList.add('d-none');
                step3.classList.remove('d-none');

                // Get the selected course details
                fetch(`/teacher/get-course-details?course_id=${courseSelect.value}`)
                    .then(response => response.json())
                    .then(course => {
                        // Display course info
                        document.getElementById('displayCourseCode').textContent = course.code;
                        document.getElementById('displayCourseTitle').textContent = course.title;
                        document.getElementById('displayCreditHours').textContent = course.credit_hours;
                        document.getElementById('displayCourseType').textContent = course.course_type;

                        // Fetch students for the selected session
                        fetch(`/teacher/get-students?session=${sessionInput.value}`)
                            .then(response => response.json())
                            .then(students => {
                                // Generate table based on course type
                                generateMarksTable(course.course_type, students);
                            });
                    });
            });

            // Back to step 2
            step3BackButton.addEventListener('click', function () {
                step3.classList.add('d-none');
                step2.classList.remove('d-none');
            });

            // Generate marks table based on course type
            function generateMarksTable(courseType, students) {
                const container = document.getElementById('marksTableContainer');
                let tableHTML = '';

                if (courseType === 'theory') {
                    tableHTML = `
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Participation (10)</th>
                                    <th>Class Test (30)</th>
                                    <th>Final (60)</th>
                                    <th>Total (100)</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    students.forEach((student, index) => {
                        tableHTML += `
                            <tr>
                                <td>
                                    <input type="hidden" name="students[${index}][student_id]" value="${student.id}">
                                    <input type="hidden" name="students[${index}][session]" value="${sessionInput.value}">
                                    <span class="fw-semibold">${student.studentid}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">${student.name}</span>
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][participation]" min="0" max="10" class="form-control form-control-sm marks-input participation-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][ct]" min="0" max="30" class="form-control form-control-sm marks-input ct-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][semester_final]" min="0" max="60" class="form-control form-control-sm marks-input final-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][total]" readonly class="form-control form-control-sm total-mark bg-light">
                                </td>
                                <td>
                                    <input type="text" name="students[${index}][grade]" readonly class="form-control form-control-sm grade bg-light">
                                    <input type="hidden" name="students[${index}][grade_point]" class="grade-point">
                                </td>
                            </tr>
                        `;
                    });

                    tableHTML += `
                            </tbody>
                        </table>
                    `;
                } else if (courseType === 'lab') {
                    tableHTML = `
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name</th>
                                    <th>Lab Report (20)</th>
                                    <th>Lab Work (40)</th>
                                    <th>Attendance (10)</th>
                                    <th>Viva (30)</th>
                                    <th>Total (100)</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;

                    students.forEach((student, index) => {
                        tableHTML += `
                            <tr>
                                <td>
                                    <input type="hidden" name="students[${index}][student_id]" value="${student.id}">
                                    <input type="hidden" name="students[${index}][session]" value="${sessionInput.value}">
                                    <span class="fw-semibold">${student.studentid}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold">${student.name}</span>
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][report]" min="0" max="20" class="form-control form-control-sm marks-input report-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][lab_work]" min="0" max="40" class="form-control form-control-sm marks-input lab-work-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][attendance]" min="0" max="10" class="form-control form-control-sm marks-input attendance-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][viva]" min="0" max="30" class="form-control form-control-sm marks-input viva-mark">
                                </td>
                                <td>
                                    <input type="number" name="students[${index}][total]" readonly class="form-control form-control-sm total-mark bg-light">
                                </td>
                                <td>
                                    <input type="text" name="students[${index}][grade]" readonly class="form-control form-control-sm grade bg-light">
                                    <input type="hidden" name="students[${index}][grade_point]" class="grade-point">
                                </td>
                            </tr>
                        `;
                    });

                    tableHTML += `
                            </tbody>
                        </table>
                    `;
                }

                container.innerHTML = tableHTML;

                // Add event listeners for mark calculation
                setupMarkCalculations(courseType);
            }

            // Setup event listeners for mark calculations
            function setupMarkCalculations(courseType) {
                const rows = document.querySelectorAll('#marksTableContainer tbody tr');

                rows.forEach(row => {
                    if (courseType === 'theory') {
                        const participationInput = row.querySelector('.participation-mark');
                        const ctInput = row.querySelector('.ct-mark');
                        const finalInput = row.querySelector('.final-mark');
                        const totalInput = row.querySelector('.total-mark');
                        const gradeInput = row.querySelector('.grade');
                        const gradePointInput = row.querySelector('.grade-point');

                        // Calculate total marks and grade
                        function calculateTheoryMarks() {
                            if (participationInput.value && ctInput.value && finalInput.value) {
                                const participation = parseFloat(participationInput.value) || 0;
                                const ct = parseFloat(ctInput.value) || 0;
                                const final = parseFloat(finalInput.value) || 0;

                                const total = participation + ct + final;
                                totalInput.value = total.toFixed(2);

                                const { grade, gradePoint } = calculateGrade(total);
                                gradeInput.value = grade;
                                gradePointInput.value = gradePoint;
                            }
                        }

                        participationInput.addEventListener('input', calculateTheoryMarks);
                        ctInput.addEventListener('input', calculateTheoryMarks);
                        finalInput.addEventListener('input', calculateTheoryMarks);

                    } else if (courseType === 'lab') {
                        const reportInput = row.querySelector('.report-mark');
                        const labWorkInput = row.querySelector('.lab-work-mark');
                        const attendanceInput = row.querySelector('.attendance-mark');
                        const vivaInput = row.querySelector('.viva-mark');
                        const totalInput = row.querySelector('.total-mark');
                        const gradeInput = row.querySelector('.grade');
                        const gradePointInput = row.querySelector('.grade-point');

                        // Calculate total marks and grade
                        function calculateLabMarks() {
                            if (reportInput.value && labWorkInput.value && attendanceInput.value && vivaInput.value) {
                                const report = parseFloat(reportInput.value) || 0;
                                const labWork = parseFloat(labWorkInput.value) || 0;
                                const attendance = parseFloat(attendanceInput.value) || 0;
                                const viva = parseFloat(vivaInput.value) || 0;

                                const total = report + labWork + attendance + viva;
                                totalInput.value = total.toFixed(2);

                                const { grade, gradePoint } = calculateGrade(total);
                                gradeInput.value = grade;
                                gradePointInput.value = gradePoint;
                            }
                        }

                        reportInput.addEventListener('input', calculateLabMarks);
                        labWorkInput.addEventListener('input', calculateLabMarks);
                        attendanceInput.addEventListener('input', calculateLabMarks);
                        vivaInput.addEventListener('input', calculateLabMarks);
                    }
                });
            }

            // Calculate grade and grade point from total marks
            function calculateGrade(totalMarks) {
                let grade, gradePoint;

                if (totalMarks >= 80) {
                    grade = 'A+';
                    gradePoint = 4.00;
                } else if (totalMarks >= 75) {
                    grade = 'A';
                    gradePoint = 3.75;
                } else if (totalMarks >= 70) {
                    grade = 'A-';
                    gradePoint = 3.50;
                } else if (totalMarks >= 65) {
                    grade = 'B+';
                    gradePoint = 3.25;
                } else if (totalMarks >= 60) {
                    grade = 'B';
                    gradePoint = 3.00;
                } else if (totalMarks >= 55) {
                    grade = 'B-';
                    gradePoint = 2.75;
                } else if (totalMarks >= 50) {
                    grade = 'C+';
                    gradePoint = 2.50;
                } else if (totalMarks >= 45) {
                    grade = 'C';
                    gradePoint = 2.25;
                } else if (totalMarks >= 40) {
                    grade = 'D';
                    gradePoint = 2.00;
                } else {
                    grade = 'F';
                    gradePoint = 0.00;
                }

                return { grade, gradePoint };
            }

            // Save marks
            saveMarksButton.addEventListener('click', function () {
                const courseId = courseSelect.value;
                const formData = {
                    course_id: courseId,
                    students: []
                };

                // Get all rows in the table
                const rows = document.querySelectorAll('#marksTableContainer tbody tr');

                // Extract data from each row
                rows.forEach(row => {
                    const studentData = {};

                    // Get all input fields in this row
                    const inputs = row.querySelectorAll('input');
                    inputs.forEach(input => {
                        if (input.name) {
                            const nameParts = input.name.match(/students\[(\d+)\]\[([^\]]+)\]/);
                            if (nameParts) {
                                const field = nameParts[2];
                                studentData[field] = input.value;
                            }
                        }
                    });

                    formData.students.push(studentData);
                });

                // Send data to the server
                fetch('/teacher/save-marks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Marks saved successfully!');
                        } else {
                            alert('Failed to save marks.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while saving marks.');
                    });
            });
        });
    </script>
@endsection
