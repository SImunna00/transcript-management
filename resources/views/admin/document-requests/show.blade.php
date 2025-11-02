<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Request Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <x-form-feedback type="success" :message="session('success')" class="mb-4" />
            @endif

            @if (session('error'))
                <x-form-feedback type="error" :message="session('error')" class="mb-4" />
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.document-requests.index') }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            &larr; Back to all requests
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Request Details -->
                        <div class="lg:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Request Information</h3>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Request ID</div>
                                    <div class="text-sm text-gray-900">#{{ $documentRequest->id }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Document Type</div>
                                    <div class="text-sm text-gray-900 capitalize">{{ $documentRequest->document_type }}
                                    </div>
                                </div>

                                @if($documentRequest->document_type == 'marksheet')
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="text-sm font-medium text-gray-500">Academic Year</div>
                                        <div class="text-sm text-gray-900">{{ $documentRequest->year }}</div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="text-sm font-medium text-gray-500">Term</div>
                                        <div class="text-sm text-gray-900">{{ $documentRequest->term }}</div>
                                    </div>
                                @elseif($documentRequest->document_type == 'testimonial')
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="text-sm font-medium text-gray-500">Session</div>
                                        <div class="text-sm text-gray-900">{{ $documentRequest->session }}</div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div class="text-sm font-medium text-gray-500">Purpose</div>
                                        <div class="text-sm text-gray-900">{{ $documentRequest->purpose ?? 'N/A' }}</div>
                                    </div>
                                @endif

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Status</div>
                                    <div class="text-sm">
                                        @if($documentRequest->status == 'pending')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($documentRequest->status == 'approved')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                        @elseif($documentRequest->status == 'rejected')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Amount</div>
                                    <div class="text-sm text-gray-900">৳{{ $documentRequest->amount }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Payment Status</div>
                                    <div class="text-sm">
                                        @if($documentRequest->payment_status == 'paid')
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Requested On</div>
                                    <div class="text-sm text-gray-900">
                                        {{ $documentRequest->created_at->format('M d, Y H:i A') }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Student Information -->
                        <div class="lg:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Student Information</h3>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Name</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->name }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Student ID</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->studentid }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Email</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->email }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Phone</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->phone ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Session</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->session ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Father's Name</div>
                                    <div class="text-sm text-gray-900">
                                        {{ $documentRequest->user->father_name ?? 'N/A' }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Mother's Name</div>
                                    <div class="text-sm text-gray-900">
                                        {{ $documentRequest->user->mother_name ?? 'N/A' }}</div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Hall Name</div>
                                    <div class="text-sm text-gray-900">{{ $documentRequest->user->hall_name ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="text-sm font-medium text-gray-500">Room Number</div>
                                    <div class="text-sm text-gray-900">
                                        {{ $documentRequest->user->room_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Panel -->
                        <div class="lg:col-span-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>

                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-medium mb-3">Update Request Status</h4>

                                <x-main-form :action="route('admin.document-requests.update-status', $documentRequest->id)" method="PATCH">
                                    <div class="mb-4">
                                        <label for="status"
                                            class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select id="status" name="status"
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="pending" {{ $documentRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="approved" {{ $documentRequest->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="rejected" {{ $documentRequest->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <x-loading-button type="primary" class="w-full">
                                        Update Status
                                    </x-loading-button>
                                </x-main-form>

                                <div class="border-t border-gray-200 my-4"></div>

                                <h4 class="font-medium mb-3">Generate Document</h4>

                                @if($documentRequest->document_type == 'marksheet')
                                    <a href="{{ route('admin.document-requests.generate-marksheet', $documentRequest->id) }}"
                                        class="w-full mb-3 inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        x-data="{ loading: false }" @click="loading = true"
                                        :class="{ 'opacity-50 cursor-wait': loading }">
                                        <span x-show="!loading">Generate Marksheet</span>
                                        <span x-show="loading" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Generating...
                                        </span>
                                    </a>
                                @elseif($documentRequest->document_type == 'testimonial')
                                    <a href="{{ route('admin.document-requests.generate-testimonial', $documentRequest->id) }}"
                                        class="w-full mb-3 inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        x-data="{ loading: false }" @click="loading = true"
                                        :class="{ 'opacity-50 cursor-wait': loading }">
                                        <span x-show="!loading">Generate Testimonial</span>
                                        <span x-show="loading" class="flex items-center">
                                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            Generating...
                                        </span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>