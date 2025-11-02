<x-admin-layout>
    <div class="py-8 px-4 md:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">
                <i class="fas fa-file-alt text-blue-600 mr-2"></i> Transcript Requests
            </h1>
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-home mr-1"></i> Home
                </a>
                <span class="text-gray-500">/</span>
                <span class="text-gray-700">Transcript Requests</span>
            </div>
        </div>

        <!-- Process Info Box -->
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Transcript Approval Process</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ol class="list-decimal list-inside space-y-1">
                            <li><strong>Payment Confirmation:</strong> Confirm student payment first (if not already paid)</li>
                            <li><strong>Approve Transcript:</strong> Click "Approve Transcript" to automatically link the marksheet file</li>
                            <li><strong>Student Access:</strong> Once approved, students can download their transcript from their dashboard</li>
                        </ol>
                        <p class="mt-2 text-xs italic">💡 The system automatically finds and links the matching marksheet PDF for each student's session, year, and term.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-blue-100">
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Total Requests</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $stats['total_requests'] ?? 0 }}</h3>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3">
                        <i class="fas fa-file-alt text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-yellow-100">
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Pending</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $stats['pending_requests'] ?? 0 }}</h3>
                    </div>
                    <div class="rounded-full bg-yellow-100 p-3">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-green-100">
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Completed</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $stats['completed_requests'] ?? 0 }}</h3>
                    </div>
                    <div class="rounded-full bg-green-100 p-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-red-100">
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Total Revenue</p>
                        <h3 class="text-xl font-bold text-gray-800">৳{{ number_format($stats['total_revenue'] ?? 0, 2) }}</h3>
                    </div>
                    <div class="rounded-full bg-red-100 p-3">
                        <i class="fas fa-money-bill text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="border-b border-gray-200 px-4 py-3">
                <h2 class="text-lg font-medium text-gray-800">Filter Requests</h2>
            </div>
            <div class="p-4">
                <form method="GET" action="{{ route('admin.transcript-requests.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Academic Year</label>
                            <select name="year" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Years</option>
                                <option value="1st" {{ request('year') == '1st' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd" {{ request('year') == '2nd' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd" {{ request('year') == '3rd' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th" {{ request('year') == '4th' ? 'selected' : '' }}>4th Year</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Term</label>
                            <select name="term" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">All Terms</option>
                                <option value="1st" {{ request('term') == '1st' ? 'selected' : '' }}>1st Term</option>
                                <option value="2nd" {{ request('term') == '2nd' ? 'selected' : '' }}>2nd Term</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Student name or ID..." 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div class="flex items-end space-x-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                                <i class="fas fa-filter mr-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.transcript-requests.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                                <i class="fas fa-times mr-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <a href="{{ route('admin.transcript-requests.index') }}" 
                        class="py-3 px-4 text-center border-b-2 font-medium text-sm {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        All Requests
                        <span class="ml-1 px-2 py-0.5 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $statusCounts['all'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.transcript-requests.index', ['status' => 'pending']) }}" 
                        class="py-3 px-4 text-center border-b-2 font-medium text-sm {{ request('status') == 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Pending
                        <span class="ml-1 px-2 py-0.5 bg-yellow-100 text-yellow-600 rounded-full text-xs">{{ $statusCounts['pending'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.transcript-requests.index', ['status' => 'paid']) }}" 
                        class="py-3 px-4 text-center border-b-2 font-medium text-sm {{ request('status') == 'paid' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Paid
                        <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-600 rounded-full text-xs">{{ $statusCounts['paid'] ?? 0 }}</span>
                    </a>
                    <a href="{{ route('admin.transcript-requests.index', ['status' => 'completed']) }}" 
                        class="py-3 px-4 text-center border-b-2 font-medium text-sm {{ request('status') == 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Completed
                        <span class="ml-1 px-2 py-0.5 bg-blue-100 text-blue-600 rounded-full text-xs">{{ $statusCounts['completed'] ?? 0 }}</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md" role="alert">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Requests Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="border-b border-gray-200 px-4 py-3">
                <h2 class="text-lg font-medium text-gray-800">Transcript Requests</h2>
            </div>
            <div class="p-4">
                @if(isset($requests) && $requests->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th style="width: 18%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Student Name</th>
                                    <th style="width: 10%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Student ID</th>
                                    <th style="width: 10%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Session</th>
                                    <th style="width: 10%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Academic Year</th>
                                    <th style="width: 8%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Term</th>
                                    <th style="width: 12%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Payment Status</th>
                                    <th style="width: 12%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                    <th style="width: 20%;" class="py-3 px-4 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($requests as $request)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <span class="font-medium">{{ $request->user->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            {{ $request->user->studentid ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            {{ $request->session ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            {{ $request->academic_year ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            {{ $request->term ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if($request->payment_status === 'paid')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check-circle mr-1"></i> Paid
                                                </span>
                                            @elseif($request->payment_status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-clock mr-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class="fas fa-times-circle mr-1"></i> Failed
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            @if($request->status === 'completed')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-check-double mr-1"></i> Completed
                                                </span>
                                            @elseif($request->status === 'pending')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-hourglass-half mr-1"></i> Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    <i class="fas fa-minus mr-1"></i> {{ ucfirst($request->status ?? 'N/A') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4">
                                            @if($request->payment_status === 'paid')
                                                @if($request->status === 'completed' && isset($request->transcript_path) && $request->transcript_path)
                                                    <div class="flex items-center justify-center space-x-2">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                            <i class="fas fa-check mr-1"></i> ✅ Approved
                                                        </span>
                                                        <a href="{{ Storage::url($request->transcript_path) }}"
                                                            class="inline-flex items-center px-2.5 py-1.5 border border-blue-300 shadow-sm text-xs font-medium rounded text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
                                                            target="_blank" title="View/Download Transcript PDF">
                                                            <i class="fas fa-download mr-1"></i> View PDF
                                                        </a>
                                                        @if($request->uploaded_at)
                                                            <span class="text-xs text-gray-500" title="Approved on {{ $request->uploaded_at->format('M d, Y \a\t h:i A') }}">
                                                                <i class="fas fa-clock mr-1"></i>{{ $request->uploaded_at->diffForHumans() }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <form action="{{ route('admin.upload', $request->id) }}" method="POST"
                                                        class="flex items-center justify-center approve-form">
                                                        @csrf
                                                        <button type="submit" 
                                                            class="approve-btn inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200"
                                                            onclick="return confirmApproval('{{ $request->user->name ?? 'this student' }}', '{{ $request->user->studentid ?? 'N/A' }}')">
                                                            <i class="fas fa-check mr-2"></i> 
                                                            <span class="btn-text">Approve Transcript</span>
                                                            <span class="loading-text hidden">
                                                                <i class="fas fa-spinner fa-spin mr-2"></i> Processing...
                                                            </span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <div class="flex items-center justify-center space-x-2">
                                                    <form action="{{ route('admin.upload', $request->id) }}" method="POST" class="payment-form">
                                                        @csrf
                                                        <input type="hidden" name="action" value="mark_paid">
                                                        <button type="submit" 
                                                            class="payment-btn inline-flex items-center px-3 py-1.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200"
                                                            onclick="return confirmPayment('{{ $request->user->name ?? 'this student' }}', '{{ number_format($request->amount ?? 0, 2) }}')">
                                                            <i class="fas fa-dollar-sign mr-1"></i> 
                                                            <span class="payment-btn-text">Confirm Payment</span>
                                                            <span class="payment-loading-text hidden">
                                                                <i class="fas fa-spinner fa-spin mr-1"></i> Confirming...
                                                            </span>
                                                        </button>
                                                    </form>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <i class="fas fa-hourglass-half mr-1"></i> Awaiting Payment
                                                    </span>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($requests->hasPages())
                        <div class="mt-4 flex justify-center">
                            {{ $requests->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-pdf text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-700">No transcript requests found.</h3>
                        <p class="text-gray-500 mt-2">Students haven't submitted any transcript requests yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function confirmApproval(studentName, studentId) {
            return confirm(`🎓 Are you sure you want to approve the transcript for:\n\nStudent: ${studentName}\nStudent ID: ${studentId}\n\nThis will:\n✅ Copy the marksheet file to transcript request\n✅ Update status to "Completed"\n✅ Allow student to download their transcript\n\nClick OK to proceed.`);
        }

        function confirmPayment(studentName, amount) {
            return confirm(`💳 Are you sure you want to confirm payment for:\n\nStudent: ${studentName}\nAmount: ৳${amount}\n\nThis will mark the payment as "Paid" and allow transcript approval.\n\nClick OK to proceed.`);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const approveForms = document.querySelectorAll('.approve-form');
            approveForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('.approve-btn');
                    const btnText = button.querySelector('.btn-text');
                    const loadingText = button.querySelector('.loading-text');
                    
                    button.disabled = true;
                    button.classList.add('opacity-75', 'cursor-not-allowed');
                    btnText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
                });
            });

            const paymentForms = document.querySelectorAll('.payment-form');
            paymentForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const button = this.querySelector('.payment-btn');
                    const btnText = button.querySelector('.payment-btn-text');
                    const loadingText = button.querySelector('.payment-loading-text');
                    
                    button.disabled = true;
                    button.classList.add('opacity-75', 'cursor-not-allowed');
                    btnText.classList.add('hidden');
                    loadingText.classList.remove('hidden');
                });
            });

            const flashMessages = document.querySelectorAll('[role="alert"]');
            flashMessages.forEach(message => {
                setTimeout(() => {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }, 5000);
            });

            const viewButtons = document.querySelectorAll('[title="View Transcript"]');
            viewButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.title = 'Click to download/view the approved transcript PDF';
                });
            });
        });
    </script>
</x-admin-layout>
