{{-- resources/views/admin/marksheets/create.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generate New Marksheet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <i class="fas fa-home mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                            <a href="{{ route('admin.marksheets.index') }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600">Marksheets</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500">Generate New</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Marksheet Generation Form</h3>
                            <p class="text-sm text-gray-600 mt-1">Fill in the details to generate a new marksheet</p>
                        </div>

                        <form id="marksheetForm" method="POST" action="{{ route('admin.marksheets.store') }}"
                            class="p-6">
                            @csrf

                            <!-- Student Selection -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Student Information</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="student_select"
                                            class="block text-sm font-medium text-gray-700 mb-2">Student *</label>
                                        <select name="user_id" id="student_select"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2" required
                                            aria-describedby="student_help">
                                            <option value="">Select Student</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}"
                                                    data-studentid="{{ $student->studentid }}"
                                                    data-email="{{ $student->email }}"
                                                    data-department="{{ $student->department ?? '-' }}"
                                                    data-session="{{ $student->session ?? '' }}"
                                                    data-academic-year-id="{{ $student->academic_year_id ?? '' }}"
                                                    data-term-id="{{ $student->term_id ?? '' }}">
                                                    {{ $student->name }} ({{ $student->studentid }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <p id="student_help" class="text-sm text-gray-500 mt-1">Select a student to view
                                            their marks.</p>
                                        @error('user_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="student_search"
                                            class="block text-sm font-medium text-gray-700 mb-2">Search Student</label>
                                        <input type="text" id="student_search" placeholder="Type to search students..."
                                            class="w-full border border-gray-300 rounded-md px-3 py-2"
                                            aria-describedby="search_help">
                                        <p id="search_help" class="text-sm text-gray-500 mt-1">Search by name or student
                                            ID.</p>
                                    </div>
                                </div>

                                <div id="student_details" class="mt-4 p-4 bg-gray-50 rounded-lg hidden">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Student ID</label>
                                            <p id="display_studentid" class="text-sm font-medium text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Email</label>
                                            <p id="display_email" class="text-sm font-medium text-gray-900">-</p>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500">Department</label>
                                            <p id="display_department" class="text-sm font-medium text-gray-900">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Academic Information</h4>
                                <div class="mb-2">
                                    <p class="text-sm text-blue-600">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Fields with green background are auto-filled from student record
                                    </p>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="session_select"
                                            class="block text-sm font-medium text-gray-700 mb-2">Session *</label>
                                        <select name="session" id="session_select"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2" required
                                            aria-describedby="session_help">
                                            <option value="">Select Session</option>
                                            @foreach($sessions as $session)
                                                <option value="{{ $session }}">{{ $session }}</option>
                                            @endforeach
                                        </select>
                                        <p id="session_help" class="text-sm text-gray-500 mt-1">Select the academic
                                            session.</p>
                                        @error('session')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="academic_year_select"
                                            class="block text-sm font-medium text-gray-700 mb-2">Academic Year *</label>
                                        <select name="academic_year_id" id="academic_year_select"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2" required
                                            aria-describedby="year_help">
                                            <option value="">Select Academic Year</option>
                                            @foreach($academicYears as $year)
                                                <option value="{{ $year->id }}">{{ $year->name }} Year</option>
                                            @endforeach
                                        </select>
                                        <p id="year_help" class="text-sm text-gray-500 mt-1">Select the academic year.
                                        </p>
                                        @error('academic_year_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="term_select"
                                            class="block text-sm font-medium text-gray-700 mb-2">Term *</label>
                                        <select name="term_id" id="term_select"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2" required
                                            aria-describedby="term_help">
                                            <option value="">Select Term</option>
                                            @foreach($terms as $term)
                                                <option value="{{ $term->id }}">{{ $term->name }} Term</option>
                                            @endforeach
                                        </select>
                                        <p id="term_help" class="text-sm text-gray-500 mt-1">Select the term for the
                                            marksheet.</p>
                                        @error('term_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Generation Options -->
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-800 mb-4">Generation Options</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Marksheet
                                            Type</label>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <label class="flex items-center">
                                                <input type="radio" name="marksheet_type" value="official" checked
                                                    class="mr-2">
                                                <span class="text-sm">Official Transcript</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="marksheet_type" value="provisional"
                                                    class="mr-2">
                                                <span class="text-sm">Provisional Certificate</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="marksheet_type" value="grade_report"
                                                    class="mr-2">
                                                <span class="text-sm">Grade Report</span>
                                            </label>
                                        </div>
                                        @error('marksheet_type')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="include_grades" checked class="mr-2">
                                                <span class="text-sm">Include Letter Grades</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="include_gpa" checked class="mr-2">
                                                <span class="text-sm">Include GPA Calculation</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="include_cgpa" checked class="mr-2">
                                                <span class="text-sm">Include CGPA</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="flex items-center">
                                                <input type="checkbox" name="include_rank" class="mr-2">
                                                <span class="text-sm">Include Class Rank</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="notes"
                                            class="block text-sm font-medium text-gray-700 mb-2">Additional
                                            Notes</label>
                                        <textarea name="notes" id="notes" rows="3"
                                            class="w-full border border-gray-300 rounded-md px-3 py-2"
                                            placeholder="Any special instructions or notes for this marksheet..."></textarea>
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                    <a href="{{ route('admin.marksheets.index') }}"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                        <i class="fas fa-arrow-left mr-2"></i>Back to List
                                    </a>

                                    <div class="flex space-x-2">
                                        <button type="button" onclick="previewMarksheet()"
                                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            <i class="fas fa-eye mr-2"></i>Preview
                                        </button>
                                        <button type="submit" id="submitBtn"
                                            class="text-white font-bold py-2 px-4 rounded transition-colors duration-200"
                                            disabled>
                                            <i class="fas fa-file-pdf mr-2"></i>Generate Marksheet
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Course Marks Preview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800">Course Marks Preview</h3>
                            <p class="text-sm text-gray-600 mt-1">Select student and academic details to preview marks
                            </p>
                        </div>
                        <div id="marks_preview" class="p-6 overflow-x-auto">
                            <p class="text-sm text-gray-500 text-center">No data available</p>
                        </div>
                    </div>



                    <!-- Help & Tips -->
                    <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-blue-800 mb-4">
                                <i class="fas fa-info-circle mr-2"></i>Tips & Guidelines
                            </h3>
                            <div class="space-y-3 text-sm text-blue-700">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <span>Ensure student has marks recorded for the selected term</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <span>Official transcripts require payment confirmation</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <span>Preview before generating to avoid errors</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <span>Generated marksheets are automatically saved</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50"
        role="dialog" aria-labelledby="previewModalTitle">
        <div class="relative top-10 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 id="previewModalTitle" class="text-lg font-medium text-gray-900">Marksheet Preview</h3>
                    <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700"
                        aria-label="Close preview modal">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div id="preview_content"
                    class="border border-gray-200 rounded-lg p-6 bg-white min-h-96 overflow-x-auto">
                    <div class="text-center text-gray-500">
                        <i class="fas fa-spinner fa-spin text-2xl mb-4"></i>
                        <p>Loading preview...</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button onclick="closePreviewModal()"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Close
                    </button>
                    <button onclick="generateFromPreview()"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Generate This Marksheet
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const previewUrl = '{{ route('admin.marks-preview') }}';
            const submitBtn = document.getElementById('submitBtn');

            // Set initial button state
            function setButtonDisabled() {
                submitBtn.disabled = true;
                submitBtn.style.backgroundColor = '#9CA3AF'; // gray-400
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.style.opacity = '0.6';
            }

            function setButtonEnabled() {
                submitBtn.disabled = false;
                submitBtn.style.backgroundColor = '#059669'; // green-600
                submitBtn.style.cursor = 'pointer';
                submitBtn.style.opacity = '1';
                submitBtn.onmouseover = function () {
                    this.style.backgroundColor = '#047857'; // green-700
                };
                submitBtn.onmouseout = function () {
                    this.style.backgroundColor = '#059669'; // green-600
                };
            }

            // Initialize button as disabled
            setButtonDisabled();

            // Student search functionality
            document.getElementById('student_search').addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const select = document.getElementById('student_select');
                const options = select.querySelectorAll('option');

                options.forEach(option => {
                    if (option.value === '') return;
                    const text = option.textContent.toLowerCase();
                    option.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Student selection change
            document.getElementById('student_select').addEventListener('change', function () {
                const option = this.options[this.selectedIndex];
                const detailsDiv = document.getElementById('student_details');

                if (this.value) {
                    // Display student details
                    document.getElementById('display_studentid').textContent = option.dataset.studentid || '-';
                    document.getElementById('display_email').textContent = option.dataset.email || '-';
                    document.getElementById('display_department').textContent = option.dataset.department || '-';
                    detailsDiv.classList.remove('hidden');

                    // Auto-fill academic information
                    const sessionSelect = document.getElementById('session_select');
                    const academicYearSelect = document.getElementById('academic_year_select');
                    const termSelect = document.getElementById('term_select');

                    // Fill session
                    if (option.dataset.session) {
                        sessionSelect.value = option.dataset.session;
                        sessionSelect.classList.add('bg-green-50', 'border-green-300');
                        sessionSelect.title = 'Auto-filled from student record';
                    } else {
                        sessionSelect.classList.remove('bg-green-50', 'border-green-300');
                        sessionSelect.title = '';
                    }

                    // Fill academic year
                    if (option.dataset.academicYearId) {
                        academicYearSelect.value = option.dataset.academicYearId;
                        academicYearSelect.classList.add('bg-green-50', 'border-green-300');
                        academicYearSelect.title = 'Auto-filled from student record';
                    } else {
                        academicYearSelect.classList.remove('bg-green-50', 'border-green-300');
                        academicYearSelect.title = '';
                    }

                    // Fill term
                    if (option.dataset.termId) {
                        termSelect.value = option.dataset.termId;
                        termSelect.classList.add('bg-green-50', 'border-green-300');
                        termSelect.title = 'Auto-filled from student record';
                    } else {
                        termSelect.classList.remove('bg-green-50', 'border-green-300');
                        termSelect.title = '';
                    }

                    // Load marks preview after auto-filling
                    setTimeout(() => {
                        loadMarksPreview();
                    }, 100);
                } else {
                    detailsDiv.classList.add('hidden');

                    // Reset academic information fields
                    const sessionSelect = document.getElementById('session_select');
                    const academicYearSelect = document.getElementById('academic_year_select');
                    const termSelect = document.getElementById('term_select');

                    sessionSelect.value = '';
                    academicYearSelect.value = '';
                    termSelect.value = '';

                    // Remove auto-fill styling
                    [sessionSelect, academicYearSelect, termSelect].forEach(select => {
                        select.classList.remove('bg-green-50', 'border-green-300');
                        select.title = '';
                    });

                    document.getElementById('marks_preview').innerHTML = `
                                                        <div class="p-4 bg-gray-50 border rounded-lg text-center">
                                                            <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                                                            <p class="text-sm text-gray-600">Please select a student to begin.</p>
                                                        </div>
                                                    `;
                    setButtonDisabled();
                }
            });

            // Academic details change
            ['session_select', 'academic_year_select', 'term_select'].forEach(id => {
                document.getElementById(id).addEventListener('change', loadMarksPreview);
            });

            function loadMarksPreview() {
                const userId = document.getElementById('student_select').value;
                const session = document.getElementById('session_select').value;
                const academicYearId = document.getElementById('academic_year_select').value;
                const termId = document.getElementById('term_select').value;
                const previewDiv = document.getElementById('marks_preview');

                // Debug: Log the parameters being sent
                console.log('Loading marks preview with parameters:', {
                    userId, session, academicYearId, termId
                });

                if (userId && session && academicYearId && termId) {
                    previewDiv.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin text-blue-500 mr-2"></i>Loading marks...</div>';
                    setButtonDisabled();

                    // Construct URL with proper encoding
                    const url = `${previewUrl}?user_id=${encodeURIComponent(userId)}&session=${encodeURIComponent(session)}&academic_year_id=${encodeURIComponent(academicYearId)}&term_id=${encodeURIComponent(termId)}`;

                    console.log('Fetching URL:', url);

                    fetch(url, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => {
                            console.log('Response status:', response.status);
                            console.log('Response headers:', response.headers);

                            if (!response.ok) {
                                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Received data:', data);

                            if (data.error) {
                                throw new Error(data.error);
                            }

                            if (data.marks && data.marks.length > 0) {
                                let html = `
                                                                <table class="w-full border border-gray-300 min-w-full">
                                                                    <thead>
                                                                        <tr class="bg-gray-100">
                                                                            <th class="border border-gray-300 px-4 py-2 text-xs">Course</th>
                                                                            <th class="border border-gray-300 px-4 py-2 text-xs">Credits</th>
                                                                            <th class="border border-gray-300 px-4 py-2 text-xs">Grade</th>
                                                                            <th class="border border-gray-300 px-4 py-2 text-xs">GP</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                            `;
                                data.marks.forEach(mark => {
                                    const gradePoint = parseFloat(mark.grade_point) || 0;
                                    html += `
                                                                    <tr>
                                                                        <td class="border border-gray-300 px-4 py-2 text-xs">${mark.course.name}</td>
                                                                        <td class="border border-gray-300 px-4 py-2 text-center text-xs">${mark.course.credits}</td>
                                                                        <td class="border border-gray-300 px-4 py-2 text-center font-bold text-xs">${mark.grade || 'F'}</td>
                                                                        <td class="border border-gray-300 px-4 py-2 text-center text-xs">${gradePoint.toFixed(2)}</td>
                                                                    </tr>
                                                                `;
                                });
                                html += `
                                                                    </tbody>
                                                                </table>
                                                                <div class="mt-4 p-4 bg-blue-50 rounded-lg text-sm text-gray-800">
                                                                    <p><strong>Estimated TGPA:</strong> <span class="font-bold">${(parseFloat(data.estimated_tgpa) || 0).toFixed(2)}</span></p>
                                                                    <p><strong>Total Credits for Term:</strong> <span class="font-bold">${data.total_credits || 'N/A'}</span></p>
                                                                    <p class="mt-2 text-green-600 font-semibold">Marks found. You can now generate the marksheet.</p>
                                                                </div>
                                                            `;
                                previewDiv.innerHTML = html;
                                setButtonEnabled();
                                console.log('Button should now be enabled:', submitBtn.disabled);
                                console.log('Button element:', submitBtn);
                            } else {
                                previewDiv.innerHTML = `
                                                                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-center">
                                                                    <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                                                                    <p class="text-sm text-yellow-800 font-semibold">No Marks Found</p>
                                                                    <p class="text-xs text-yellow-700 mt-1">No marks have been recorded for this student for the selected term. Please ensure marks are entered before generating a marksheet.</p>
                                                                </div>
                                                            `;
                                setButtonDisabled();
                            }
                        })
                        .catch(error => {
                            console.error('Detailed error:', error);
                            previewDiv.innerHTML = `
                                                            <div class="p-4 bg-red-50 border border-red-200 rounded-lg text-center">
                                                                <i class="fas fa-times-circle text-red-500 text-2xl mb-2"></i>
                                                                <p class="text-sm text-red-800 font-semibold">Error Loading Marks</p>
                                                                <p class="text-xs text-red-700 mt-1">Error: ${error.message}</p>
                                                                <p class="text-xs text-red-600 mt-1">Check browser console for details.</p>
                                                            </div>
                                                        `;
                            setButtonDisabled();
                        });
                } else {
                    previewDiv.innerHTML = `
                                                        <div class="p-4 bg-gray-50 border rounded-lg text-center">
                                                            <i class="fas fa-info-circle text-gray-400 text-2xl mb-2"></i>
                                                            <p class="text-sm text-gray-600">Please select a student, session, year, and term to preview their marks.</p>
                                                        </div>
                                                    `;
                    setButtonDisabled();
                }
            }

            function previewMarksheet() {
                const form = document.getElementById('marksheetForm');
                const formData = new FormData(form);
                const requiredFields = ['user_id', 'session', 'academic_year_id', 'term_id'];

                for (let field of requiredFields) {
                    if (!formData.get(field)) {
                        alert(`Please fill in the ${field.replace('_', ' ')} field.`);
                        return;
                    }
                }

                document.getElementById('previewModal').classList.remove('hidden');
                document.getElementById('preview_content').innerHTML = `
                                                    <div class="text-center text-gray-500">
                                                        <i class="fas fa-spinner fa-spin text-2xl mb-4"></i>
                                                        <p>Loading preview...</p>
                                                    </div>
                                                `;

                fetch('{{ route("admin.marksheets.preview") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'text/html'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('preview_content').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading preview:', error);
                        document.getElementById('preview_content').innerHTML = '<p class="text-red-500 text-center">Error loading preview. Please try again.</p>';
                    });
            }

            function closePreviewModal() {
                document.getElementById('previewModal').classList.add('hidden');
            }

            function generateFromPreview() {
                document.getElementById('marksheetForm').submit();
            }

            // Form validation
            document.getElementById('marksheetForm').addEventListener('submit', function (e) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    alert('Cannot generate marksheet. Please ensure marks are loaded and valid.');
                    return;
                }

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
                setButtonDisabled();

                // Allow the form to submit, but prevent double-submission
                setTimeout(() => {
                    submitBtn.innerHTML = '<i class="fas fa-file-pdf mr-2"></i>Generate Marksheet';
                    // The button will be re-enabled on page load, or stay disabled if there's an error.
                }, 5000);
            });            // Form validation
            document.getElementById('marksheetForm').addEventListener('submit', function (e) {
                if (submitBtn.disabled) {
                    e.preventDefault();
                    alert('Cannot generate marksheet. Please ensure marks are loaded and valid.');
                    return;
                }

                e.preventDefault(); // Prevent immediate submission

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generating...';
                setButtonDisabled();

                // Refresh CSRF token before submission
                refreshCSRFToken()
                    .then(() => {
                        // Now submit the form
                        document.getElementById('marksheetForm').submit();
                    })
                    .catch(error => {
                        console.error('Error refreshing CSRF token:', error);
                        // Try to submit anyway
                        document.getElementById('marksheetForm').submit();
                    });
            });
        </script>
    @endpush
</x-admin-layout>