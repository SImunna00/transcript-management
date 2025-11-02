
<!-- TRANSCRIPT REQUEST DETAIL VIEW - resources/views/admin/transcript-requests/show.blade.php -->
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transcript Request Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('admin.transcript-requests.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Requests
                </a>
            </div>

            <!-- Request Details Card -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Request #{{ $request->id }}</h3>
                        @switch($request->status)
                            @case('pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i>
                                    Pending
                                </span>
                                @break
                            @case('approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-check mr-1"></i>
                                    Approved
                                </span>
                                @break
                            @case('rejected')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>
                                    Rejected
                                </span>
                                @break
                            @case('generated')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-file-pdf mr-1"></i>
                                    Generated
                                </span>
                                @break
                            @default
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    Unknown
                                </span>
                        @endswitch
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-user mr-2 text-blue-600"></i>
                                Student Information
                            </h4>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Name:</label>
                                    <p class="text-gray-800 font-medium">{{ $request->user->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Student ID:</label>
                                    <p class="text-gray-800 font-mono">{{ $request->user->studentid }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Email:</label>
                                    <p class="text-gray-800">
                                        <a href="mailto:{{ $request->user->email }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $request->user->email }}
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Phone:</label>
                                    <p class="text-gray-800">
                                        @if($request->user->phone)
                                            <a href="tel:{{ $request->user->phone }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $request->user->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">N/A</span>
                                        @endif
                                    </p>
                                </div>
                                @if($request->user->department)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Department:</label>
                                    <p class="text-gray-800">{{ $request->user->department }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Request Information -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-file-alt mr-2 text-green-600"></i>
                                Request Information
                            </h4>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Session:</label>
                                    <p class="text-gray-800 font-medium">{{ $request->session ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Academic Year:</label>
                                    <p class="text-gray-800">{{ $request->year ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Term:</label>
                                    <p class="text-gray-800">{{ $request->term ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Request Date:</label>
                                    <p class="text-gray-800">{{ $request->created_at->format('F j, Y g:i A') }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Request Type:</label>
                                    <p class="text-gray-800">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $request->request_type ?? 'Transcript' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Payment Status:</label>
                                    <div class="flex items-center space-x-2">
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
                                        @if($request->amount)
                                            <span class="text-gray-600 font-medium">${{ number_format($request->amount, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if($request->additional_info)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                            Additional Information
                        </h4>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                            <p class="text-gray-700">{{ $request->additional_info }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Processing Information -->
                    @if($request->processed_by || $request->admin_notes || $request->processed_at)
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-cogs mr-2 text-gray-600"></i>
                            Processing Information
                        </h4>
                        <div class="bg-gray-50 p-4 rounded-lg border">
                            @if($request->processed_by)
                            <div class="mb-3">
                                <label class="text-sm font-medium text-gray-600">Processed By:</label>
                                <p class="text-gray-800 font-medium">{{ $request->processedBy->name ?? 'N/A' }}</p>
                            </div>
                            @endif
                            @if($request->processed_at)
                            <div class="mb-3">
                                <label class="text-sm font-medium text-gray-600">Processed At:</label>
                                <p class="text-gray-800">{{ $request->processed_at->format('F j, Y g:i A') }}</p>
                            </div>
                            @endif
                            @if($request->admin_notes)
                            <div>
                                <label class="text-sm font-medium text-gray-600">Admin Notes:</label>
                                <div class="mt-1 p-3 bg-white border rounded">
                                    <p class="text-gray-800">{{ $request->admin_notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Document History -->
                    @if($request->marksheet_file || $request->status === 'generated')
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-file-pdf mr-2 text-red-600"></i>
                            Generated Documents
                        </h4>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            @if($request->marksheet_file)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-600 mr-3"></i>
                                        <div>
                                            <p class="font-medium text-gray-800">Marksheet PDF</p>
                                            <p class="text-sm text-gray-600">Generated on {{ $request->updated_at->format('F j, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('admin.transcript-requests.download', $request->id) }}" 
                                       class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded transition-colors">
                                        <i class="fas fa-download mr-1"></i>Download
                                    </a>
                                </div>
                            @else
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <span>Document is ready but file path not available</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Marks Availability Check -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-clipboard-check mr-2 text-blue-600"></i>
                        Marks Availability
                    </h3>
                </div>
                <div class="p-6">
                    @if(isset($marksExist) && $marksExist)
                        <div class="flex items-center text-green-600 bg-green-50 p-4 rounded-lg border border-green-200">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium">Marks are available for this student</p>
                                <p class="text-sm text-green-700">Session: {{ $request->session }}, Year: {{ $request->year }}, Term: {{ $request->term }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center text-red-600 bg-red-50 p-4 rounded-lg border border-red-200">
                            <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                            <div>
                                <p class="font-medium">No marks found for this student</p>
                                <p class="text-sm text-red-700 mt-1">
                                    Please ensure that teachers have entered marks for the specified session and term before generating the marksheet.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-tasks mr-2 text-purple-600"></i>
                        Available Actions
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-3">
                        @if($request->status === 'pending')
                            <form method="POST" action="{{ route('admin.transcript-requests.approve', $request->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center"
                                        onclick="return confirm('Are you sure you want to approve this request?')">
                                    <i class="fas fa-check mr-2"></i>Approve Request
                                </button>
                            </form>
                            
                            <button onclick="openRejectModal()" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                <i class="fas fa-times mr-2"></i>Reject Request
                            </button>
                        @endif

                        @if($request->status === 'approved')
                            @if(isset($marksExist) && $marksExist)
                                <form method="POST" action="{{ route('admin.transcript-requests.generate-marksheet', $request->id) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center"
                                            onclick="return confirm('Generate marksheet PDF for this request?')">
                                        <i class="fas fa-file-pdf mr-2"></i>Generate Marksheet
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed inline-flex items-center"
                                        title="Cannot generate marksheet without marks">
                                    <i class="fas fa-file-pdf mr-2"></i>Generate Marksheet (No Marks)
                                </button>
                            @endif
                        @endif

                        @if($request->status === 'generated' && $request->marksheet_file)
                            <a href="{{ route('admin.transcript-requests.download', $request->id) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                <i class="fas fa-download mr-2"></i>Download Marksheet PDF
                            </a>
                            
                            <button onclick="openRegenerateModal()" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                                <i class="fas fa-redo mr-2"></i>Regenerate Marksheet
                            </button>
                        @endif

                        @if($request->status === 'rejected')
                            <form method="POST" action="{{ route('admin.transcript-requests.reopen', $request->id) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center"
                                        onclick="return confirm('Are you sure you want to reopen this request?')">
                                    <i class="fas fa-undo mr-2"></i>Reopen Request
                                </button>
                            </form>
                        @endif

                        <!-- Send Email Notification -->
                        <button onclick="openEmailModal()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors inline-flex items-center">
                            <i class="fas fa-envelope mr-2"></i>Send Email
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-times-circle text-red-600 mr-2"></i>
                    Reject Request
                </h3>
                <form method="POST" action="{{ route('admin.transcript-requests.reject', $request->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection <span class="text-red-500">*</span></label>
                        <textarea name="admin_notes" rows="4" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                  placeholder="Please provide a detailed reason for rejection..." required></textarea>
                        <p class="text-xs text-gray-500 mt-1">This reason will be sent to the student via email.</p>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRejectModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            <i class="fas fa-times mr-1"></i>
                            Reject Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Regenerate Modal -->
    <div id="regenerateModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-redo text-orange-600 mr-2"></i>
                    Regenerate Marksheet
                </h3>
                <div class="mb-4">
                    <p class="text-sm text-gray-600">
                        This will create a new marksheet PDF with the latest marks data. The previous file will be replaced.
                    </p>
                </div>
                <form method="POST" action="{{ route('admin.transcript-requests.generate-marksheet', $request->id) }}">
                    @csrf
                    <input type="hidden" name="regenerate" value="1">
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeRegenerateModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            <i class="fas fa-redo mr-1"></i>
                            Regenerate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Email Modal -->
    <div id="emailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-envelope text-purple-600 mr-2"></i>
                    Send Email Notification
                </h3>
                <form method="POST" action="{{ route('admin.transcript-requests.send-email', $request->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Template</label>
                        <select name="template" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="status_update">Status Update</option>
                            <option value="request_approved">Request Approved</option>
                            <option value="marksheet_ready">Marksheet Ready</option>
                            <option value="custom">Custom Message</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Additional Message</label>
                        <textarea name="message" rows="3" 
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500" 
                                  placeholder="Optional additional message..."></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="closeEmailModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded transition-colors">
                            <i class="fas fa-paper-plane mr-1"></i>
                            Send Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function openRegenerateModal() {
            document.getElementById('regenerateModal').classList.remove('hidden');
        }

        function closeRegenerateModal() {
            document.getElementById('regenerateModal').classList.add('hidden');
        }

        function openEmailModal() {
            document.getElementById('emailModal').classList.remove('hidden');
        }

        function closeEmailModal() {
            document.getElementById('emailModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = ['rejectModal', 'regenerateModal', 'emailModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        }

        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const rejectForm = document.querySelector('#rejectModal form');
            if (rejectForm) {
                rejectForm.addEventListener('submit', function(e) {
                    const textarea = this.querySelector('textarea[name="admin_notes"]');
                    if (textarea.value.trim().length < 10) {
                        e.preventDefault();
                        alert('Please provide a detailed reason (at least 10 characters) for rejection.');
                        textarea.focus();
                    }
                });
            }
        });
    </script>
</x-admin-layout>
