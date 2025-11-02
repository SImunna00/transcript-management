<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Document Requests Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">All Document Requests</h3>
                        </div>

                        <div class="flex space-x-2">
                            <form method="GET" action="{{ route('admin.document-requests.index') }}"
                                class="flex items-center">
                                <select name="status"
                                    class="mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>
                                        Rejected</option>
                                </select>

                                <select name="document_type"
                                    class="mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">All Types</option>
                                    <option value="marksheet" {{ request('document_type') == 'marksheet' ? 'selected' : '' }}>Marksheet</option>
                                    <option value="testimonial" {{ request('document_type') == 'testimonial' ? 'selected' : '' }}>Testimonial</option>
                                </select>

                                <select name="payment_status"
                                    class="mr-2 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">All Payment Statuses</option>
                                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>
                                        Failed</option>
                                </select>

                                <button type="submit"
                                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded-md text-sm">Filter</button>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">ID</th>
                                    <th class="py-2 px-4 border-b text-left">Student</th>
                                    <th class="py-2 px-4 border-b text-left">Document</th>
                                    <th class="py-2 px-4 border-b text-left">Details</th>
                                    <th class="py-2 px-4 border-b text-left">Status</th>
                                    <th class="py-2 px-4 border-b text-left">Payment</th>
                                    <th class="py-2 px-4 border-b text-left">Requested On</th>
                                    <th class="py-2 px-4 border-b text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border-b">{{ $request->id }}</td>
                                        <td class="py-2 px-4 border-b">
                                            {{ $request->user->name }}<br>
                                            <span class="text-xs text-gray-500">ID: {{ $request->user->studentid }}</span>
                                        </td>
                                        <td class="py-2 px-4 border-b capitalize">{{ $request->document_type }}</td>
                                        <td class="py-2 px-4 border-b">
                                            @if($request->document_type == 'marksheet')
                                                Year {{ $request->year }}, Term {{ $request->term }}
                                            @elseif($request->document_type == 'testimonial')
                                                Session: {{ $request->session }}
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border-b">
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
                                        <td class="py-2 px-4 border-b">
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
                                        <td class="py-2 px-4 border-b">{{ $request->created_at->format('M d, Y') }}</td>
                                        <td class="py-2 px-4 border-b">
                                            <a href="{{ route('admin.document-requests.show', $request->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Manage</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-6 text-center text-gray-500">No document requests found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $requests->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>