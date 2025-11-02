<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Document Requests Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <a href="{{ route('student.document-requests.index') }}" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Document Requests</h3>
                                <p class="mt-1 text-sm text-gray-500">Request marksheets and testimonials</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- Request New Document Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <a href="{{ route('document-requests.create') }}" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">New Request</h3>
                                <p class="mt-1 text-sm text-gray-500">Submit a new document request</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- Profile Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                    <a href="{{ route('profile.edit') }}" class="block p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Profile</h3>
                                <p class="mt-1 text-sm text-gray-500">Manage your profile information</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Document Requests</h3>

                    @php
                        $recentRequests = Auth::user()->documentRequests()
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentRequests->isEmpty())
                        <p class="text-sm text-gray-500">You haven't made any document requests yet.</p>
                        <div class="mt-4">
                            <a href="{{ route('document-requests.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Request a Document
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Payment</th>
                                        <th
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date</th>
                                        <th class="px-4 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentRequests as $request)
                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <span class="capitalize">{{ $request->document_type }}</span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                @if($request->status == 'pending')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($request->status == 'approved')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                                @elseif($request->status == 'rejected')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                @if($request->payment_status == 'pending')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($request->payment_status == 'paid')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Paid</span>
                                                @elseif($request->payment_status == 'failed')
                                                    <span
                                                        class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Failed</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                {{ $request->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-right">
                                                <a href="{{ route('document-requests.show', $request->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-right">
                            <a href="{{ route('student.document-requests.index') }}"
                                class="text-sm text-indigo-600 hover:text-indigo-900">View all requests &rarr;</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>