@extends('layouts.teacher')

@section('title', 'Mark Entry')
@section('page-title', 'Student Mark Entry')

@section('content')
    <div class="container-fluid">
        <!-- Selection Form -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i> Student Mark Entry</h5>
            </div>
            <div class="card-body">
                <form id="selectionForm">
                    @csrf
                    <div class="row g-3">
                        <!-- Year Selection -->
                        <div class="col-md-4">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <select id="academic_year" name="academic_year" class="form-select" required>
                                <option value="">Select Year</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Term Selection -->
                        <div class="col-md-4">
                            <label for="term" class="form-label">Term</label>
                            <select id="term" name="term" class="form-select" required disabled>
                                <option value="">Select Term</option>
                                @foreach ($terms as $term)
                                    <option value="{{ $term->id }}">{{ $term->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Course Selection -->
                        <div class="col-md-4">
                            <label for="course_id" class="form-label">Course</label>
                            <select id="course_id" name="course_id" class="form-select" required disabled>
                                <option value="">Select Course</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i> Courses will be filtered locally from preloaded data
                        </small>
                        <button type="button" id="markEntryBtn" class="btn btn-primary" disabled>
                            <i class="fas fa-edit me-1"></i> Mark Entry
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mark Entry Container -->
        <div id="markEntryContainer" class="d-none">
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="fas fa-info-circle fa-2x me-3"></i>
                <div>
                    <h5 class="alert-heading mb-0" id="courseInfo">Course Information</h5>
                    <p class="mb-0" id="studentCount">Loading students...</p>
                </div>
                <div class="ms-auto">
                    <span class="badge bg-primary p-2 fs-6" id="progressIndicator">
                        <i class="fas fa-spinner me-1"></i> 0/0 Complete
                    </span>
                </div>
            </div>

            <form id="markEntryForm" action="{{ route('teacher.storeMarkEntry') }}" method="POST">
                @csrf
                <input type="hidden" name="course_id" id="selected_course_id">
                <input type="hidden" name="academic_year_id" id="selected_academic_year"> <!-- Updated -->
                <input type="hidden" name="term_id" id="selected_term"> <!-- Updated -->
                <input type="hidden" name="course_name" id="selected_course_name">
                <input type="hidden" name="course_code" id="selected_course_code">
                <input type="hidden" name="course_type" id="selected_course_type">

                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Student Marks</h5>
                        <button type="button" class="btn btn-sm btn-light me-2" id="saveProgressBtn">
                            <i class="fas fa-save me-1"></i> Save Progress
                        </button>
                    </div>

                    <div class="card-body p-0">
                        <!-- Theory Table -->
                        <div id="theoryTable" class="table-responsive d-none">
                            <table class="table table-striped table-hover mb-0" id="marksTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-3" width="5%">#</th>
                                        <th class="px-3" width="20%">Student Name</th>
                                        <th class="px-3" width="12%">Student ID</th>
                                        <th class="px-3" width="10%">Session</th>
                                        <th class="px-3" width="10%">Attendance</th>
                                        <th class="px-3" width="10%">CT Marks</th>
                                        <th class="px-3" width="10%">Semester</th>
                                        <th class="px-3" width="10%">Total</th>
                                        <th class="px-3" width="5%">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBody"></tbody>
                            </table>
                        </div>

                        <!-- Lab Table -->
                        <div id="labTable" class="table-responsive d-none">
                            <table class="table table-striped table-hover mb-0" id="marksTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-3" width="5%">#</th>
                                        <th class="px-3" width="18%">Student Name</th>
                                        <th class="px-3" width="10%">Student ID</th>
                                        <th class="px-3" width="9%">Session</th>
                                        <th class="px-3" width="9%">Attendance</th>
                                        <th class="px-3" width="9%">Report</th>
                                        <th class="px-3" width="9%">Lab Work</th>
                                        <th class="px-3" width="9%">Viva</th>
                                        <th class="px-3" width="10%">Total</th>
                                        <th class="px-3" width="5%">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBodyLab"></tbody>
                            </table>
                        </div>

                        <!-- Special Table -->
                        <div id="specialTable" class="table-responsive d-none">
                            <table class="table table-striped table-hover mb-0" id="marksTable">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-3" width="5%">#</th>
                                        <th class="px-3" width="30%">Student Name</th>
                                        <th class="px-3" width="20%">Student ID</th>
                                        <th class="px-3" width="20%">Session</th>
                                        <th class="px-3" width="15%">Total</th>
                                        <th class="px-3" width="10%">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="studentTableBodySpecial"></tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="confirmSubmit" required>
                                    <label class="form-check-label" for="confirmSubmit">
                                        I confirm all marks are correct and ready for submission.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-success" id="submitBtn" disabled>
                                    <i class="fas fa-paper-plane me-1"></i> Submit All Marks
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- No Students Alert -->
        <div id="noStudentsAlert" class="alert alert-warning d-none">
            <i class="fas fa-exclamation-triangle me-2"></i> No students found for the selected course.
        </div>
    </div>

    <!-- Success Toast -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="successToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success text-white">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="me-auto">Success</strong>
                <small>Just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">Marks saved successfully!</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Store all courses from the backend in a JavaScript variable
        const allCoursesData = @json($allCourses);

        document.addEventListener('DOMContentLoaded', function () {
            const academicYearSelect = document.getElementById('academic_year');
            const termSelect = document.getElementById('term');
            const courseSelect = document.getElementById('course_id');
            const markEntryBtn = document.getElementById('markEntryBtn');
            const markEntryContainer = document.getElementById('markEntryContainer');
            const noStudentsAlert = document.getElementById('noStudentsAlert');
            const confirmSubmitCheckbox = document.getElementById('confirmSubmit');
            const submitBtn = document.getElementById('submitBtn');
            const saveProgressBtn = document.getElementById('saveProgressBtn');

            const selectedCourseId = document.getElementById('selected_course_id');
            const selectedAcademicYear = document.getElementById('selected_academic_year');
            const selectedTerm = document.getElementById('selected_term');
            const selectedCourseName = document.getElementById('selected_course_name');
            const selectedCourseCode = document.getElementById('selected_course_code');
            const selectedCourseType = document.getElementById('selected_course_type');

            const courseInfo = document.getElementById('courseInfo');
            const studentCount = document.getElementById('studentCount');
            const progressIndicator = document.getElementById('progressIndicator');
            const successToast = document.getElementById('successToast');
            const toastMessage = document.getElementById('toastMessage');

            // Enable term select when academic year is selected
            academicYearSelect.addEventListener('change', function () {
                console.log('🎓 Academic year changed to:', this.value);

                if (this.value) {
                    try {
                        // Enable the term dropdown immediately so user can select
                        termSelect.disabled = false;

                        // Clear previous selections
                        termSelect.value = '';
                        courseSelect.innerHTML = '<option value="">Select Course</option>';
                        courseSelect.disabled = true;
                        markEntryBtn.disabled = true;
                        markEntryContainer.classList.add('d-none');
                        noStudentsAlert.classList.add('d-none');

                        console.log('✅ Term dropdown enabled for academic year:', this.value);

                        // Fetch terms for the selected academic year
                        fetchTerms(this.value);
                    } catch (error) {
                        console.error('❌ Error handling academic year change:', error);
                        showToast('Error loading terms: ' + error.message, 'danger');
                    }
                } else {
                    termSelect.disabled = true;
                    courseSelect.disabled = true;
                    markEntryBtn.disabled = true;
                    showToast('Please select an academic year.', 'warning');
                }
            });

            // Enable course select when term is selected
            termSelect.addEventListener('change', function () {
                console.log('📅 Term changed to:', this.value);
                if (this.value) {
                    courseSelect.disabled = false;
                    courseSelect.innerHTML = '<option value="">Select Course</option>';
                    markEntryBtn.disabled = true;
                    markEntryContainer.classList.add('d-none');
                    noStudentsAlert.classList.add('d-none');

                    console.log('🎯 Fetching courses for year:', academicYearSelect.value, 'term:', this.value);
                    fetchCourses(academicYearSelect.value, this.value);
                } else {
                    courseSelect.disabled = true;
                    markEntryBtn.disabled = true;
                }
            });

            // Enable mark entry button when course is selected
            courseSelect.addEventListener('change', function () {
                markEntryBtn.disabled = !this.value;
            });

            // Mark entry button click
            markEntryBtn.addEventListener('click', function () {
                const yearId = academicYearSelect.value;
                const termId = termSelect.value;
                const courseId = courseSelect.value;
                const courseOption = courseSelect.options[courseSelect.selectedIndex];

                selectedCourseId.value = courseId;
                selectedAcademicYear.value = yearId;
                selectedTerm.value = termId;
                selectedCourseName.value = courseOption.dataset.name || '';
                selectedCourseCode.value = courseOption.dataset.code || '';

                // Enhanced course type detection with debugging
                let courseType = 'theory'; // default
                const courseCode = selectedCourseCode.value.toLowerCase();
                const courseName = selectedCourseName.value.toLowerCase();

                console.log('🔍 Course type detection:');
                console.log('  - Course Code:', selectedCourseCode.value);
                console.log('  - Course Name:', selectedCourseName.value);
                console.log('  - Code (lowercase):', courseCode);
                console.log('  - Name (lowercase):', courseName);

                // Check for special courses (ending with 00)
                if (selectedCourseCode.value.endsWith('00')) {
                    courseType = 'special';
                    console.log('  ✅ Detected as SPECIAL course (ends with 00)');
                }
                // Check for lab courses (course name ending with "lab" or "(lab)")
                else if (courseName.endsWith('lab') || courseName.endsWith('(lab)')) {
                    courseType = 'lab';
                    console.log('  ✅ Detected as LAB course (name ends with "lab" or "(lab)")');
                }
                else {
                    courseType = 'theory';
                    console.log('  ✅ Detected as THEORY course (default)');
                }

                selectedCourseType.value = courseType;
                console.log('  🎯 Final course type:', courseType);

                courseInfo.textContent = `${selectedCourseCode.value} - ${selectedCourseName.value}`;
                fetchStudents(courseId, yearId, termId, courseType);
            });

            // Toggle submit button based on checkbox
            confirmSubmitCheckbox.addEventListener('change', function () {
                submitBtn.disabled = !this.checked;
            });

            // Save progress button click
            saveProgressBtn.addEventListener('click', function () {
                saveProgress();
            });

            // Form submission
            document.getElementById('markEntryForm').addEventListener('submit', function (e) {
                const incompleteMarks = document.querySelectorAll('.mark-incomplete');
                if (incompleteMarks.length > 0) {
                    e.preventDefault();
                    showToast('Please complete all student marks before submitting.', 'warning');
                    incompleteMarks.forEach(row => {
                        row.classList.add('table-warning');
                        setTimeout(() => row.classList.remove('table-warning'), 2000);
                    });
                } else {
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Submitting...';
                    submitBtn.disabled = true;
                }
            });

            // AJAX Functions
            function fetchTerms(yearId) {
                // Since we're working with existing terms already loaded in the page,
                // we'll just enable the dropdown and not make an API call
                console.log('Using pre-loaded terms for academic year ID:', yearId);

                // Make sure the dropdown is enabled
                termSelect.disabled = false;

                // Keep the existing options which were loaded from the controller
                // No need to fetch them again via API

                // Ensure the toast is cleared if there was an error previously
                const toast = bootstrap.Toast.getInstance(successToast);
                if (toast) {
                    toast.hide();
                }
            }

            function fetchCourses(yearId, termId) {
                console.log(`Filtering courses for year=${yearId}, term=${termId}`);

                // Show loading indicator
                courseSelect.innerHTML = '<option value="">Loading courses...</option>';
                courseSelect.disabled = true;

                try {
                    // Convert to integers for proper comparison
                    const numYearId = parseInt(yearId, 10);
                    const numTermId = parseInt(termId, 10);

                    // Filter courses from the preloaded data
                    const filteredCourses = allCoursesData.filter(course =>
                        parseInt(course.academic_year_id, 10) === numYearId &&
                        parseInt(course.term_id, 10) === numTermId
                    );

                    console.log(`Found ${filteredCourses.length} courses locally for year=${yearId}, term=${termId}`);

                    // Reset dropdown
                    courseSelect.innerHTML = '<option value="">Select Course</option>';

                    if (!filteredCourses || filteredCourses.length === 0) {
                        showToast('No courses found for selected academic year and term.', 'warning');
                        courseSelect.disabled = true;
                        return;
                    }

                    // Add filtered courses to dropdown
                    filteredCourses.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.id;
                        option.textContent = `${course.code} - ${course.name}`;
                        option.dataset.code = course.code;
                        option.dataset.name = course.name;
                        courseSelect.appendChild(option);
                    });

                    // Enable the courses dropdown
                    courseSelect.disabled = false;

                    // If there's only one course, auto-select it
                    if (filteredCourses.length === 1) {
                        courseSelect.value = filteredCourses[0].id;
                        // Enable the mark entry button
                        markEntryBtn.disabled = false;
                    }
                } catch (error) {
                    console.error('Error filtering courses:', error);
                    showToast('Error loading courses: ' + error.message, 'danger');
                    courseSelect.innerHTML = '<option value="">Error loading courses</option>';
                    courseSelect.disabled = true;
                }
            }

            function fetchStudents(courseId, yearId, termId, courseType) {
                markEntryContainer.classList.add('d-none');
                noStudentsAlert.classList.add('d-none');

                // Show loading indicator
                studentCount.textContent = 'Loading students...';

                console.log(`🔍 Fetching students for course=${courseId}, year=${yearId}, term=${termId}, type=${courseType}`);

                // Make API call to fetch actual students
                fetch(`/api/students/${courseId}/${yearId}/${termId}?_=${new Date().getTime()}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    credentials: 'same-origin'
                })
                    .then(response => {
                        console.log(`📡 API Response status: ${response.status}`);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(students => {
                        console.log("✅ API returned students:", students);
                        console.log("📝 Type of students:", typeof students);
                        console.log("🔍 Is students an array:", Array.isArray(students));

                        // Ensure students is always an array
                        if (!Array.isArray(students)) {
                            console.log("⚠️ Students is not an array, attempting to convert...");

                            if (typeof students === 'object' && students !== null) {
                                // Convert object with numeric keys to array
                                students = Object.values(students);
                                console.log("🔄 Converted to array:", students);
                            } else {
                                console.log("❌ Could not convert students to array");
                                students = [];
                            }
                        }

                        console.log(`📊 Final student count: ${students ? students.length : 0}`);

                        if (!students || students.length === 0) {
                            console.log("⚠️ No students found, showing alert");
                            studentCount.textContent = 'No students found for this selection';
                            noStudentsAlert.classList.remove('d-none');
                            markEntryContainer.classList.add('d-none');
                            return;
                        }

                        console.log(`✨ Found ${students.length} students from API`);
                        studentCount.textContent = `${students.length} students found`;
                        noStudentsAlert.classList.add('d-none');
                        populateStudentTable(students, courseType);
                        markEntryContainer.classList.remove('d-none');
                    })
                    .catch(error => {
                        console.error("❌ Error fetching students:", error);
                        showToast('Error loading students: ' + error.message, 'danger');
                        studentCount.textContent = 'Error loading students';

                        // Fallback to test data for development
                        console.log("🔧 Falling back to test data");
                        const testStudents = [
                            { id: 1, name: "Test Student 1", student_id: "S12345", session: "2025-26" },
                            { id: 2, name: "Test Student 2", student_id: "S12346", session: "2025-26" },
                            { id: 3, name: "Test Student 3", student_id: "S12347", session: "2025-26" }
                        ];

                        studentCount.textContent = `${testStudents.length} test students (API failed)`;
                        populateStudentTable(testStudents, courseType);
                        markEntryContainer.classList.remove('d-none');
                    });
            }

            function saveProgress() {
                const formData = new FormData(document.getElementById('markEntryForm'));
                fetch('/api/mark-entry/save-progress', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to save progress');
                        }
                        return response.json();
                    })
                    .then(data => {
                        showToast(data.message, data.status);
                        updateProgressIndicator();
                    })
                    .catch(error => showToast(error.message, 'danger'));
            }

            function populateStudentTable(students, courseType) {
                console.log(`🏗️ Populating student table with ${students.length} students, course type: ${courseType}`);

                try {
                    // Hide all tables first
                    document.getElementById('theoryTable').classList.add('d-none');
                    document.getElementById('labTable').classList.add('d-none');
                    document.getElementById('specialTable').classList.add('d-none');

                    console.log(`📋 Tables hidden, selecting table for course type: ${courseType}`);

                    // Select the appropriate table based on course type
                    let tableBody, tableDiv;
                    if (courseType === 'lab') {
                        tableBody = document.getElementById('studentTableBodyLab');
                        tableDiv = document.getElementById('labTable');
                        console.log('🧪 Using LAB table');
                    } else if (courseType === 'special') {
                        tableBody = document.getElementById('studentTableBodySpecial');
                        tableDiv = document.getElementById('specialTable');
                        console.log('⭐ Using SPECIAL table');
                    } else {
                        tableBody = document.getElementById('studentTableBody');
                        tableDiv = document.getElementById('theoryTable');
                        console.log('📚 Using THEORY table (default)');
                    }

                    console.log(`🎯 Selected elements:`, {
                        tableBody: tableBody ? 'found' : 'NOT FOUND',
                        tableDiv: tableDiv ? 'found' : 'NOT FOUND',
                        courseType: courseType
                    });

                    if (!tableDiv || !tableBody) {
                        throw new Error(`Table elements not found for course type: ${courseType}`);
                    }

                    // Show the selected table
                    tableDiv.classList.remove('d-none');
                    console.log(`✅ Table div shown: ${tableDiv.id}, classes: ${tableDiv.className}`);

                    // Clear existing content
                    tableBody.innerHTML = '';
                    console.log('🗑️ Table body cleared');

                    // Populate the table
                    console.log(`Adding ${students.length} student rows to table`);
                    students.forEach((student, index) => {
                        console.log(`Creating row for student #${index + 1}:`, student);
                        const row = document.createElement('tr');
                        row.className = 'mark-incomplete'; // Mark all as incomplete initially

                        if (courseType === 'theory') {
                            row.innerHTML = `
                                    <td class="px-3">${index + 1}</td>
                                    <td class="px-3">${student.name}</td>
                                    <td class="px-3">${student.student_id || 'N/A'}</td>
                                    <td class="px-3">${student.session || 'N/A'}</td>
                                    <td class="px-3">
                                        <input type="number" name="attendance[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                        <input type="hidden" name="student_ids[]" value="${student.id}">
                                    </td>
                                    <td class="px-3">
                                        <input type="number" name="ct_marks[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                    </td>
                                    <td class="px-3">
                                        <input type="number" name="semester[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                    </td>
                                    <td class="px-3">
                                        <span class="total-mark">0</span>
                                    </td>
                                    <td class="px-3 text-center">
                                        <span class="badge rounded-pill bg-warning">Pending</span>
                                    </td>
                                `;
                        } else if (courseType === 'lab') {
                            row.innerHTML = `
                                    <td class="px-3">${index + 1}</td>
                                    <td class="px-3">${student.name}</td>
                                    <td class="px-3">${student.student_id || 'N/A'}</td>
                                    <td class="px-3">${student.session || 'N/A'}</td>
                                    <td class="px-3">
                                        <input type="number" name="attendance[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                        <input type="hidden" name="student_ids[]" value="${student.id}">
                                    </td>
                                    <td class="px-3">
                                        <input type="number" name="report[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                    </td>
                                    <td class="px-3">
                                        <input type="number" name="lab_work[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                    </td>
                                    <td class="px-3">
                                        <input type="number" name="viva[${student.id}]" min="0" class="form-control form-control-sm mark-input" required>
                                    </td>
                                    <td class="px-3">
                                        <span class="total-mark">0</span>
                                    </td>
                                    <td class="px-3 text-center">
                                        <span class="badge rounded-pill bg-warning">Pending</span>
                                    </td>
                                `;
                        } else {
                            // Special course
                            row.innerHTML = `
                                    <td class="px-3">${index + 1}</td>
                                    <td class="px-3">${student.name}</td>
                                    <td class="px-3">${student.student_id || 'N/A'}</td>
                                    <td class="px-3">${student.session || 'N/A'}</td>
                                    <td class="px-3">
                                        <input type="number" name="total_mark[${student.id}]" min="0" class="form-control form-control-sm special-mark-input" required>
                                        <input type="hidden" name="student_ids[]" value="${student.id}">
                                    </td>
                                    <td class="px-3 text-center">
                                        <span class="badge rounded-pill bg-warning">Pending</span>
                                    </td>
                                `;
                        }

                        tableBody.appendChild(row);
                        console.log(`Row ${index + 1} added to table`);
                    });

                    // Add event listeners to calculate total marks
                    console.log('🎧 Adding input event listeners');
                    addMarkInputListeners(courseType);

                    // Update the progress indicator
                    console.log('📊 Updating progress indicator');
                    updateProgressIndicator();

                    // Verify the correct table is visible
                    console.log('🔍 Final verification - checking table visibility:');
                    console.log('  - Theory table visible:', !document.getElementById('theoryTable').classList.contains('d-none'));
                    console.log('  - Lab table visible:', !document.getElementById('labTable').classList.contains('d-none'));
                    console.log('  - Special table visible:', !document.getElementById('specialTable').classList.contains('d-none'));
                    console.log('  - Expected table type:', courseType);

                    // Force the table to be visible
                    console.log('✅ Final check: ensuring mark entry container is visible');
                    markEntryContainer.classList.remove('d-none');
                    console.log('Mark entry container class:', markEntryContainer.className);

                } catch (error) {
                    console.error('Error populating student table:', error);
                    showToast('Error preparing mark entry table: ' + error.message, 'danger');
                }
            }

            function addMarkInputListeners(courseType) {
                if (courseType === 'theory') {
                    document.querySelectorAll('#studentTableBody tr').forEach(row => {
                        const inputs = row.querySelectorAll('.mark-input');
                        const totalSpan = row.querySelector('.total-mark');
                        const statusBadge = row.querySelector('.badge');

                        inputs.forEach(input => {
                            input.addEventListener('input', () => {
                                calculateTotalMark(inputs, totalSpan, statusBadge, row);
                            });
                        });
                    });
                } else if (courseType === 'lab') {
                    document.querySelectorAll('#studentTableBodyLab tr').forEach(row => {
                        const inputs = row.querySelectorAll('.mark-input');
                        const totalSpan = row.querySelector('.total-mark');
                        const statusBadge = row.querySelector('.badge');

                        inputs.forEach(input => {
                            input.addEventListener('input', () => {
                                calculateTotalMark(inputs, totalSpan, statusBadge, row);
                            });
                        });
                    });
                } else {
                    document.querySelectorAll('#studentTableBodySpecial tr').forEach(row => {
                        const input = row.querySelector('.special-mark-input');
                        const statusBadge = row.querySelector('.badge');

                        input.addEventListener('input', () => {
                            if (input.value && input.value >= 0) {
                                statusBadge.className = 'badge rounded-pill bg-success';
                                statusBadge.textContent = 'Complete';
                                row.classList.remove('mark-incomplete');
                            } else {
                                statusBadge.className = 'badge rounded-pill bg-warning';
                                statusBadge.textContent = 'Pending';
                                row.classList.add('mark-incomplete');
                            }

                            updateProgressIndicator();
                        });
                    });
                }
            }

            function calculateTotalMark(inputs, totalSpan, statusBadge, row) {
                let total = 0;
                let complete = true;

                inputs.forEach(input => {
                    const val = parseFloat(input.value) || 0;
                    total += val;

                    if (!input.value || isNaN(val) || val < 0) {
                        complete = false;
                    }
                });

                totalSpan.textContent = total;

                if (complete) {
                    statusBadge.className = 'badge rounded-pill bg-success';
                    statusBadge.textContent = 'Complete';
                    row.classList.remove('mark-incomplete');
                } else {
                    statusBadge.className = 'badge rounded-pill bg-warning';
                    statusBadge.textContent = 'Pending';
                    row.classList.add('mark-incomplete');
                }

                updateProgressIndicator();
            }

            // Helper Functions
            function showToast(message, type = 'success') {
                toastMessage.textContent = message;
                successToast.classList.remove('bg-success', 'bg-danger', 'bg-warning');
                successToast.classList.add(`bg-${type}`);
                const toast = new bootstrap.Toast(successToast);
                toast.show();
            }

            function updateProgressIndicator() {
                const totalStudents = document.querySelectorAll('#studentTableBody tr, #studentTableBodyLab tr, #studentTableBodySpecial tr').length;
                const completedStudents = totalStudents - document.querySelectorAll('.mark-incomplete').length;
                progressIndicator.innerHTML = `<i class="fas fa-spinner me-1"></i> ${completedStudents}/${totalStudents} Complete`;
                if (completedStudents === totalStudents) {
                    showToast('All students have been marked.', 'success');
                }
            }
        });
    </script>
@endpush