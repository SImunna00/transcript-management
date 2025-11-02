{{-- resources/views/admin/marksheets/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Marksheets Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                            <i class="fas fa-file-pdf text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Generated</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_generated'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Draft Marksheets</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['draft_marksheets'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Published</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['published_marksheets'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Bar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-center space-x-4 mb-4 lg:mb-0">
                            <h3 class="text-lg font-semibold text-gray-800">Generated Marksheets</h3>
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                {{ $marksheets->total() }} Total
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('admin.marksheets.create') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-plus mr-2"></i>Generate New
                            </a>
                            <button onclick="showBulkGenerateModal()" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-file-alt mr-2"></i>Bulk Generate
                            </button>
                            <button onclick="openBulkDownloadModal()" 
                                    class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-download mr-2"></i>Bulk Download
                            </button>
                            <button onclick="openRegenerateModal()" 
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-redo mr-2"></i>Regenerate
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.marksheets.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label for="session_filter" class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                            <select name="session" id="session_filter" class="w-full border border-gray-300 rounded-md px-3 py-2" aria-describedby="session_filter_help">
                                <option value="">All Sessions</option>
                                @foreach($sessions as $session)
                                    <option value="{{ $session }}" {{ request('session') == $session ? 'selected' : '' }}>{{ $session }}</option>
                                @endforeach
                            </select>
                            <p id="session_filter_help" class="text-sm text-gray-500 mt-1">Filter by academic session.</p>
                        </div>
                        <div>
                            <label for="academic_year_filter" class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                            <select name="academic_year_id" id="academic_year_filter" class="w-full border border-gray-300 rounded-md px-3 py-2" aria-describedby="year_filter_help">
                                <option value="">All Years</option>
                                @foreach($academic_years as $year)
                                    <option value="{{ $year->id }}" {{ request('academic_year_id') == $year->id ? 'selected' : '' }}>
                                        {{ $year->name }} Year
                                    </option>
                                @endforeach
                            </select>
                            <p id="year_filter_help" class="text-sm text-gray-500 mt-1">Filter by academic year.</p>
                        </div>
                        <div>
                            <label for="term_filter" class="block text-sm font-medium text-gray-700 mb-2">Term</label>
                            <select name="term_id" id="term_filter" class="w-full border border-gray-300 rounded-md px-3 py-2" aria-describedby="term_filter_help">
                                <option value="">All Terms</option>
                                @foreach($terms as $term)
                                    <option value="{{ $term->id }}" {{ request('term_id') == $term->id ? 'selected' : '' }}>
                                        {{ $term->name }} Term
                                    </option>
                                @endforeach
                            </select>
                            <p id="term_filter_help" class="text-sm text-gray-500 mt-1">Filter by term.</p>
                        </div>
                        <div>
                            <label for="search_filter" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <input type="text" name="search" id="search_filter" value="{{ request('search') }}" 
                                   placeholder="Student name or ID..." 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2" aria-describedby="search_filter_help">
                            <p id="search_filter_help" class="text-sm text-gray-500 mt-1">Search by student name or ID.</p>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Marksheets Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" id="select-all" class="rounded border-gray-300" aria-label="Select all marksheets">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Academic Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grades</th>
                                
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($marksheets as $marksheet)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_marksheets[]" value="{{ $marksheet->id }}" 
                                           class="rounded border-gray-300 marksheet-checkbox" aria-label="Select marksheet for {{ $marksheet->user->name }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-medium text-sm">
                                                {{ substr($marksheet->user->name ?? 'N', 0, 2) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            @if($marksheet->user)
                                                <div class="text-sm font-medium text-gray-900">{{ $marksheet->user->name }}</div>
                                                <div class="text-sm text-gray-500">ID: {{ $marksheet->user->studentid ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $marksheet->user->email ?? 'N/A' }}</div>
                                            @else
                                                <div class="text-sm font-medium text-gray-900">N/A Student</div>
                                                <div class="text-sm text-gray-500">ID: N/A</div>
                                                <div class="text-sm text-gray-500">N/A Email</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div><strong>Session:</strong> {{ $marksheet->session }}</div>
                                        <div><strong>Year:</strong> {{ $marksheet->academicYear->name ?? 'N/A' }}</div>
                                        <div><strong>Term:</strong> {{ $marksheet->term->name ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div><strong>TGPA:</strong> {{ number_format($marksheet->tgpa, 2) }}</div>
                                        <div><strong>CGPA:</strong> {{ number_format($marksheet->cgpa, 2) }}</div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div>{{ $marksheet->created_at->format('M d, Y') }}</div>
                                        <div class="text-gray-500">{{ $marksheet->created_at->format('h:i A') }}</div>
                                        <div class="text-gray-500">by {{ $marksheet->generatedBy->name ?? 'System' }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($marksheet->status === 'published') bg-green-100 text-green-800
                                            @elseif($marksheet->status === 'draft') bg-yellow-100 text-yellow-800
                                            @elseif($marksheet->status === 'approved') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($marksheet->status ?? 'processing') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.marksheets.show', $marksheet->id) }}" 
                                           class="text-blue-600 hover:text-blue-900" title="View Details" aria-label="View marksheet details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="regenerateMarksheet({{ $marksheet->id }})" 
                                                class="text-yellow-600 hover:text-yellow-900" title="Regenerate" aria-label="Regenerate marksheet">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        <form action="{{ route('admin.marksheets.destroy', $marksheet->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this marksheet?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete" aria-label="Delete marksheet">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-file-pdf text-4xl text-gray-300 mb-4"></i>
                                        <p>No marksheets found.</p>
                                        <a href="{{ route('admin.marksheets.create') }}" 
                                           class="mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Generate First Marksheet
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($marksheets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $marksheets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bulk Generate Modal -->
    <div id="bulkGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" role="dialog" aria-labelledby="bulkGenerateModalTitle">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="bulkGenerateModalTitle" class="text-lg font-medium text-gray-900 mb-4">Bulk Generate Marksheets</h3>
                <form method="POST" action="{{ route('admin.marksheets.bulk-generate') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="bulk_session" class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                        <select name="session" id="bulk_session" class="w-full border border-gray-300 rounded-md px-3 py-2" required aria-describedby="bulk_session_help">
                            <option value="">Select Session</option>
                            @foreach($sessions as $session)
                                <option value="{{ $session }}">{{ $session }}</option>
                            @endforeach
                        </select>
                        <p id="bulk_session_help" class="text-sm text-gray-500 mt-1">Select the academic session.</p>
                    </div>
                    <div class="mb-4">
                        <label for="bulk_academic_year" class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                        <select name="academic_year_id" id="bulk_academic_year" class="w-full border border-gray-300 rounded-md px-3 py-2" required aria-describedby="bulk_year_help">
                            <option value="">Select Academic Year</option>
                            @foreach($academic_years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }}</option>
                            @endforeach
                        </select>
                        <p id="bulk_year_help" class="text-sm text-gray-500 mt-1">Select the academic year.</p>
                    </div>
                    <div class="mb-4">
                        <label for="bulk_term" class="block text-sm font-medium text-gray-700 mb-2">Term</label>
                        <select name="term_id" id="bulk_term" class="w-full border border-gray-300 rounded-md px-3 py-2" required aria-describedby="bulk_term_help">
                            <option value="">Select Term</option>
                            @foreach($terms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }}</option>
                            @endforeach
                        </select>
                        <p id="bulk_term_help" class="text-sm text-gray-500 mt-1">Select the term.</p>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" id="select_all_students" class="rounded border-gray-300 mr-2"> Select All Students
                        </label>
                        <div id="students_list" class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                            <p class="text-gray-500 text-sm">Select session, year, and term to load students.</p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="hideBulkGenerateModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Download Modal -->
    <div id="bulkDownloadModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" role="dialog" aria-labelledby="bulkDownloadModalTitle">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="bulkDownloadModalTitle" class="text-lg font-medium text-gray-900 mb-4">Bulk Download Marksheets</h3>
                <form id="bulkDownloadForm" method="POST" action="{{ route('admin.marksheets.bulk-download') }}">
                    @csrf
                    <input type="hidden" name="marksheet_ids" id="selectedMarksheetIds">
                    <div class="mb-4">
                        <label for="download_format" class="block text-sm font-medium text-gray-700 mb-2">Download Format</label>
                        <select name="format" id="download_format" class="w-full border border-gray-300 rounded-md px-3 py-2" required aria-describedby="download_format_help">
                            <option value="zip">ZIP Archive</option>
                            <option value="merged_pdf">Merged PDF</option>
                        </select>
                        <p id="download_format_help" class="text-sm text-gray-500 mt-1">Choose the download format.</p>
                    </div>
                    <div class="mb-4">
                        <label for="naming_format" class="block text-sm font-medium text-gray-700 mb-2">File Naming</label>
                        <select name="naming" id="naming_format" class="w-full border border-gray-300 rounded-md px-3 py-2" aria-describedby="naming_format_help">
                            <option value="student_id">Student ID</option>
                            <option value="student_name">Student Name</option>
                            <option value="session_year">Session + Year</option>
                        </select>
                        <p id="naming_format_help" class="text-sm text-gray-500 mt-1">Choose the file naming convention.</p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeBulkDownloadModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Regenerate Modal -->
    <div id="regenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50" role="dialog" aria-labelledby="regenerateModalTitle">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 id="regenerateModalTitle" class="text-lg font-medium text-gray-900 mb-4">Regenerate Marksheets</h3>
                <form id="regenerateForm" method="POST" action="{{ route('admin.marksheets.bulk-regenerate') }}">
                    @csrf
                    <input type="hidden" name="marksheet_ids" id="regenerateMarksheetIds">
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="update_marks" class="rounded border-gray-300 mr-2">
                            <span class="text-sm">Update with latest marks data</span>
                        </label>
                    </div>
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="backup_old" checked class="rounded border-gray-300 mr-2">
                            <span class="text-sm">Backup old versions</span>
                        </label>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    This will replace existing marksheets. Make sure to backup if needed.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRegenerateModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            Regenerate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Select all functionality
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.marksheet-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk generate
        function showBulkGenerateModal() {
            document.getElementById('bulkGenerateModal').classList.remove('hidden');
        }

        function hideBulkGenerateModal() {
            document.getElementById('bulkGenerateModal').classList.add('hidden');
        }

        document.getElementById('bulk_session').addEventListener('change', loadStudents);
        document.getElementById('bulk_academic_year').addEventListener('change', loadStudents);
        document.getElementById('bulk_term').addEventListener('change', loadStudents);

        function loadStudents() {
            const session = document.getElementById('bulk_session').value;
            const academicYearId = document.getElementById('bulk_academic_year').value;
            const termId = document.getElementById('bulk_term').value;
            const studentsList = document.getElementById('students_list');
            
            if (session && academicYearId && termId) {
                studentsList.innerHTML = '<p class="text-gray-500 text-sm">Loading students...</p>';
                fetch(`{{ route('admin.students-with-marks') }}?session=${session}&academic_year_id=${academicYearId}&term_id=${termId}`)
                    .then(response => response.json())
                    .then(students => {
                        studentsList.innerHTML = '';
                        if (students.length === 0) {
                            studentsList.innerHTML = '<p class="text-gray-500 text-sm">No students found with marks for this selection.</p>';
                            return;
                        }
                        students.forEach(student => {
                            studentsList.innerHTML += `
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="user_ids[]" value="${student.id}" 
                                           class="student-checkbox mr-2" id="student_${student.id}" aria-label="Select ${student.name}">
                                    <label for="student_${student.id}" class="text-sm">
                                        ${student.name} (${student.studentid})
                                    </label>
                                </div>
                            `;
                        });
                    })
                    .catch(error => {
                        console.error('Error loading students:', error);
                        studentsList.innerHTML = '<p class="text-red-500 text-sm">Error loading students. Please try again.</p>';
                    });
            } else {
                studentsList.innerHTML = '<p class="text-gray-500 text-sm">Select session, year, and term to load students.</p>';
            }
        }

        document.getElementById('select_all_students').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk download
        function openBulkDownloadModal() {
            const selectedCheckboxes = document.querySelectorAll('.marksheet-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one marksheet.');
                return;
            }
            const marksheetIds = Array.from(selectedCheckboxes).map(cb => cb.value);
            document.getElementById('selectedMarksheetIds').value = marksheetIds.join(',');
            document.getElementById('bulkDownloadModal').classList.remove('hidden');
        }

        function closeBulkDownloadModal() {
            document.getElementById('bulkDownloadModal').classList.add('hidden');
        }

        // Regenerate
        function openRegenerateModal() {
            const selectedCheckboxes = document.querySelectorAll('.marksheet-checkbox:checked');
            if (selectedCheckboxes.length === 0) {
                alert('Please select at least one marksheet.');
                return;
            }
            const marksheetIds = Array.from(selectedCheckboxes).map(cb => cb.value);
            document.getElementById('regenerateMarksheetIds').value = marksheetIds.join(',');
            document.getElementById('regenerateModal').classList.remove('hidden');
        }

        function closeRegenerateModal() {
            document.getElementById('regenerateModal').classList.add('hidden');
        }
    </script>
    @endpush
</x-admin-layout>
