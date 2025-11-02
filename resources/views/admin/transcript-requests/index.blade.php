
<!-- TRANSCRIPT REQUESTS INDEX - resources/views/admin/transcript-requests/index.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transcript Requests Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Action Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Manage Transcript Requests</h3>
                    <p class="text-gray-600">Review, approve, and generate marksheets for student requests</p>
                </div>
                <div class="space-x-2">
                    <button onclick="openBulkApproveModal()" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-check-double mr-2"></i>Bulk Approve
                    </button>
                    <button onclick="openBulkGenerateModal()" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-layer-group mr-2"></i>Bulk Generate
                    </button>
                    <a href="{{ route('admin.transcript-requests.export') }}" 
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-full">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-xl font-semibold">{{ $stats['pending'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-full">
                            <i class="fas fa-check text-blue-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Approved</p>
                            <p class="text-xl font-semibold">{{ $stats['approved'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-full">
                            <i class="fas fa-file-pdf text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Generated</p>
                            <p class="text-xl font-semibold">{{ $stats['generated'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-full">
                            <i class="fas fa-times text-red-600"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">Rejected</p>
                            <p class="text-xl font-semibold">{{ $stats['rejected'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">Filter Requests</h4>
                <form method="GET" action="{{ route('admin.transcript-requests.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="generated" {{ request('status') == 'generated' ? 'selected' : '' }}>Generated</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Session</label>
                            <select name="session" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Sessions</option>
                                @foreach($sessions as $session)
                                <option value="{{ $session }}" {{ request('session') == $session ? 'selected' : '' }}>{{ $session }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                            <select name="payment_status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">All Payment Status</option>
                                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('admin.transcript-requests.index') }}" 
                               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg ml-2 transition-colors">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Requests Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Transcript Requests</h3>
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="select_all" class="rounded">
                            <label for="select_all" class="text-sm text-gray-600">Select All</label>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    <input type="checkbox" class="rounded master-checkbox">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Session</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Year/Term</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($requests as $request)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_requests[]" value="{{ $request->id }}" class="rounded request-checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($request->user->name, 0, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $request->user->studentid }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->session }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $request->year }}/{{ $request->term }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($request->payment_status === 'paid')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>
                                            Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($request->status)
                                        @case('pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i>
                                                Pending
                                            </span>
                                            @break
                                        @case('approved')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-check mr-1"></i>
                                                Approved
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>
                                                Rejected
                                            </span>
                                            @break
                                        @case('generated')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-file-pdf mr-1"></i>
                                                Generated
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Unknown
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $request->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.transcript-requests.show', $request->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($request->status === 'pending')
                                            <button onclick="approveRequest({{ $request->id }})" 
                                                    class="text-green-600 hover:text-green-900 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button onclick="rejectRequest({{ $request->id }})" 
                                                    class="text-red-600 hover:text-red-900 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        
                                        @if($request->status === 'approved')
                                            <button onclick="generateMarksheet({{ $request->id }})" 
                                                    class="text-blue-600 hover:text-blue-900 transition-colors">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                        @endif
                                        
                                        @if($request->status === 'generated')
                                            <a href="{{ route('admin.transcript-requests.download', $request->id) }}" 
                                               class="text-purple-600 hover:text-purple-900 transition-colors">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No transcript requests found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        </div>
    </div>

    <!-- Bulk Approve Modal -->
    <div id="bulkApproveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Bulk Approve Requests</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to approve all selected requests?
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeBulkApproveModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button onclick="confirmBulkApprove()" 
                            class="px-4 py-2 bg-green-600 text-white text-base font-medium rounded-md hover:bg-green-700 transition-colors">
                        Approve
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Generate Modal -->
    <div id="bulkGenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Bulk Generate Marksheets</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Are you sure you want to generate marksheets for all selected requests?
                    </p>
                </div>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="closeBulkGenerateModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button onclick="confirmBulkGenerate()" 
                            class="px-4 py-2 bg-blue-600 text-white text-base font-medium rounded-md hover:bg-blue-700 transition-colors">
                        Generate
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Select all functionality
        document.getElementById('select_all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.request-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Master checkbox in table header
        document.querySelector('.master-checkbox').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.request-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Bulk approve modal functions
        function openBulkApproveModal() {
            const selectedRequests = document.querySelectorAll('.request-checkbox:checked');
            if (selectedRequests.length === 0) {
                alert('Please select at least one request to approve.');
                return;
            }
            document.getElementById('bulkApproveModal').classList.remove('hidden');
        }

        function closeBulkApproveModal() {
            document.getElementById('bulkApproveModal').classList.add('hidden');
        }

        function confirmBulkApprove() {
            const selectedRequests = Array.from(document.querySelectorAll('.request-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            fetch('{{ route("admin.transcript-requests.bulk-approve") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    request_ids: selectedRequests
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the request.');
            });
            
            closeBulkApproveModal();
        }

        // Bulk generate modal functions
        function openBulkGenerateModal() {
            const selectedRequests = document.querySelectorAll('.request-checkbox:checked');
            if (selectedRequests.length === 0) {
                alert('Please select at least one request to generate marksheets.');
                return;
            }
            document.getElementById('bulkGenerateModal').classList.remove('hidden');
        }

        function closeBulkGenerateModal() {
            document.getElementById('bulkGenerateModal').classList.add('hidden');
        }

        function confirmBulkGenerate() {
            const selectedRequests = Array.from(document.querySelectorAll('.request-checkbox:checked'))
                .map(checkbox => checkbox.value);
            
            fetch('{{ route("admin.transcript-requests.bulk-generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    request_ids: selectedRequests
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while processing the request.');
            });
            
            closeBulkGenerateModal();
        }

        // Individual request actions
        function approveRequest(requestId) {
            if (confirm('Are you sure you want to approve this request?')) {
                fetch(`{{ route('admin.transcript-requests.approve', '') }}/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the request.');
                });
            }
        }

        function rejectRequest(requestId) {
            if (confirm('Are you sure you want to reject this request?')) {
                fetch(`{{ route('admin.transcript-requests.reject', '') }}/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the request.');
                });
            }
        }

        function generateMarksheet(requestId) {
            if (confirm('Are you sure you want to generate marksheet for this request?')) {
                fetch(`{{ route('admin.transcript-requests.generate', '') }}/${requestId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while processing the request.');
                });
            }
        }
    </script>
</x-admin-layout>
