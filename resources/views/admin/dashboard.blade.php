
<!-- STEP 1: ENHANCED ADMIN DASHBOARD - resources/views/admin/dashboard.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard - Transcript Management System') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enhanced Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Students</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['total_students'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                            <i class="fas fa-clock text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Pending Requests</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['pending_requests'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Generated Marksheets -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                            <i class="fas fa-file-pdf text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Generated Marksheets</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['generated_marksheets'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Approved Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-500 bg-opacity-75">
                            <i class="fas fa-check-circle text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Approved Requests</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['approved_requests'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Paid Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-500 bg-opacity-75">
                            <i class="fas fa-credit-card text-white text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Paid Requests</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['paid_requests'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Transcript Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Transcript Management</h3>
                        <i class="fas fa-scroll text-blue-500 text-2xl"></i>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('admin.transcript-requests.index') }}" 
                           class="block w-full bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition-colors">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">Manage Requests</span>
                                <i class="fas fa-arrow-right text-gray-400"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.transcript-requests.index', ['status' => 'pending']) }}" 
                           class="block w-full bg-yellow-50 hover:bg-yellow-100 p-3 rounded-lg transition-colors">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">Pending Approvals ({{ $stats['pending_requests'] ?? 0 }})</span>
                                <i class="fas fa-clock text-yellow-500"></i>
                            </div>
                        </a>
                        <a href="{{ route('admin.transcript-requests.index', ['status' => 'approved']) }}" 
                           class="block w-full bg-green-50 hover:bg-green-100 p-3 rounded-lg transition-colors">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">Ready for Generation</span>
                                <i class="fas fa-cog text-green-500"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Marksheet Operations -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Marksheet Operations</h3>
                        <i class="fas fa-file-alt text-green-500 text-2xl"></i>
                    </div>
                    <div class="space-y-3">
                        <button onclick="openBulkGenerateModal()" 
                                class="block w-full bg-green-50 hover:bg-green-100 p-3 rounded-lg transition-colors text-left">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">Bulk Generate Marksheets</span>
                                <i class="fas fa-layer-group text-green-500"></i>
                  </div>
                        </button>
                        <button onclick="openQuickGenerateModal()" 
                                class="block w-full bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition-colors text-left">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">Quick Generate Single</span>
                                <i class="fas fa-plus-circle text-blue-500"></i>
                            </div>
                        </button>
                        <a href="{{ route('admin.transcript-requests.index', ['status' => 'generated']) }}" 
                           class="block w-full bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition-colors">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-800">View Generated PDFs</span>
                                <i class="fas fa-download text-purple-500"></i>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                        <i class="fas fa-history text-gray-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">
                        @if(isset($recent_activities) && count($recent_activities) > 0)
                            @foreach($recent_activities as $activity)
                            <div class="flex items-center space-x-3">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <div class="flex-1">
                                    <p class="text-sm text-gray-800">{{ $activity['message'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">No recent activity</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Requests Tables -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Transcript Requests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Recent Transcript Requests</h3>
                            <a href="{{ route('admin.transcript-requests.index') }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm">View All</a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year/Term</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @if(isset($recent_transcript_requests) && count($recent_transcript_requests) > 0)
                                    @foreach($recent_transcript_requests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->user->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $request->user->studentid ?? 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $request->year_term_display }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $request->status_badge }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.transcript-requests.show', $request->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No recent requests</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- System Statistics -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">System Statistics</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Request Status Distribution -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Request Status Distribution</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Pending</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ ($stats['pending_requests'] ?? 0) > 0 ? (($stats['pending_requests'] ?? 0) / ($stats['total_requests'] ?? 1)) * 100 : 0 }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $stats['pending_requests'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Approved</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($stats['approved_requests'] ?? 0) > 0 ? (($stats['approved_requests'] ?? 0) / ($stats['total_requests'] ?? 1)) * 100 : 0 }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $stats['approved_requests'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Generated</span>
                                        <div class="flex items-center space-x-2">
                                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['generated_marksheets'] ?? 0) > 0 ? (($stats['generated_marksheets'] ?? 0) / ($stats['total_requests'] ?? 1)) * 100 : 0 }}%"></div>
                                            </div>
                                            <span class="text-sm font-medium">{{ $stats['generated_marksheets'] ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Payment Status</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-green-50 rounded-lg">
                                        <div class="text-2xl font-bold text-green-600">{{ $stats['paid_requests'] ?? 0 }}</div>
                                        <div class="text-sm text-gray-600">Paid</div>
                                    </div>
                                    <div class="text-center p-3 bg-yellow-50 rounded-lg">
                                        <div class="text-2xl font-bold text-yellow-600">{{ ($stats['total_requests'] ?? 0) - ($stats['paid_requests'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-600">Pending</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Generate Modal -->
    <div id="quickGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Generate Marksheet</h3>
                <form id="quickGenerateForm" method="POST" action="{{ route('admin.marksheets.quick-generate') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                        <select name="user_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Student</option>
                            @if(isset($students))
                                @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->studentid }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                        <select name="session" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Session</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                        <select name="academic_year_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Academic Year</option>
                            @if(isset($academic_years))
                                @foreach($academic_years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }} Year</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Term</label>
                        <select name="term_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Term</option>
                            @if(isset($terms))
                                @foreach($terms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }} Term</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeQuickGenerateModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Generate Modal -->
    <div id="bulkGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Bulk Generate Marksheets</h3>
                <form method="POST" action="{{ route('admin.transcript-requests.bulk-generate') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                        <select name="session" id="bulk_session" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Session</option>
                            <option value="2023-2024">2023-2024</option>
                            <option value="2024-2025">2024-2025</option>
                            <option value="2025-2026">2025-2026</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Academic Year</label>
                        <select name="academic_year_id" id="bulk_academic_year" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Academic Year</option>
                            @if(isset($academic_years))
                                @foreach($academic_years as $year)
                                <option value="{{ $year->id }}">{{ $year->name }} Year</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Term</label>
                        <select name="term_id" id="bulk_term" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                            <option value="">Select Term</option>
                            @if(isset($terms))
                                @foreach($terms as $term)
                                <option value="{{ $term->id }}">{{ $term->name }} Term</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <input type="checkbox" id="select_all_approved"> Generate for all approved requests
                        </label>
                        <div id="approved_requests_list" class="max-h-40 overflow-y-auto border border-gray-300 rounded-md p-2">
                            <!-- Will be populated by JavaScript -->
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeBulkGenerateModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Generate All
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openQuickGenerateModal() {
            document.getElementById('quickGenerateModal').classList.remove('hidden');
        }

        function closeQuickGenerateModal() {
            document.getElementById('quickGenerateModal').classList.add('hidden');
        }

        function openBulkGenerateModal() {
            document.getElementById('bulkGenerateModal').classList.remove('hidden');
        }

        function closeBulkGenerateModal() {
            document.getElementById('bulkGenerateModal').classList.add('hidden');
        }

        // Load approved requests for bulk generation
        document.getElementById('bulk_session').addEventListener('change', loadApprovedRequests);
        document.getElementById('bulk_academic_year').addEventListener('change', loadApprovedRequests);
        document.getElementById('bulk_term').addEventListener('change', loadApprovedRequests);

        function loadApprovedRequests() {
            const session = document.getElementById('bulk_session').value;
            const academicYearId = document.getElementById('bulk_academic_year').value;
            const termId = document.getElementById('bulk_term').value;
            
            if (session && academicYearId && termId) {
                fetch(`{{ route('admin.students-with-marks') }}?session=${session}&academic_year_id=${academicYearId}&term_id=${termId}`)
                    .then(response => response.json())
                    .then(students => {
                        const requestsList = document.getElementById('approved_requests_list');
                        requestsList.innerHTML = '';
                        
                        if (students.length === 0) {
                            requestsList.innerHTML = '<p class="text-gray-500 text-sm">No students with marks found for this selection.</p>';
                            return;
                        }
                        
                        students.forEach(student => {
                            requestsList.innerHTML += `
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="user_ids[]" value="${student.id}" 
                                           class="request-checkbox mr-2" id="student_${student.id}">
                                    <label for="student_${student.id}" class="text-sm">
                                        ${student.name} (${student.studentid})
                                    </label>
                                </div>
                            `;
                        });
                    })
                    .then(response => response.json())
                    .then(requests => {
                        const requestsList = document.getElementById('approved_requests_list');
                        requestsList.innerHTML = '';
                        
                        if (requests.length === 0) {
                            requestsList.innerHTML = '<p class="text-gray-500 text-sm">No approved requests found for this selection.</p>';
                            return;
                        }
                        
                        requests.forEach(request => {
                            requestsList.innerHTML += `
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="request_ids[]" value="${request.id}" 
                                           class="request-checkbox mr-2" id="request_${request.id}">
                                    <label for="request_${request.id}" class="text-sm">
                                        ${request.user.name} (${request.user.studentid})
                                    </label>
                                </div>
                            `;
                        });
                    })
                    .catch(error => {
                        console.error('Error loading requests:', error);
                        document.getElementById('approved_requests_list').innerHTML = '<p class="text-red-500 text-sm">Error loading requests.</p>';
                    });
            }
        }

        document.getElementById('select_all_approved').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.request-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
</x-admin-layout>
