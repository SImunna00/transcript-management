<x-payment-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500 mx-auto" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>

                    <h3 class="text-lg font-medium text-gray-900 mt-4">Payment Successful!</h3>

                    <div class="mt-4 bg-green-50 border border-green-200 text-green-700 p-4 rounded-lg">
                        <p class="font-bold">
                            <i class="fas fa-check-circle mr-2"></i>Your transcript request payment has been completed successfully!
                        </p>
                        <p class="mt-2 text-sm">
                            Thank you for your payment. Your request has been received and is now under review by our admin team.
                            You will be notified once your transcript is ready for download.
                        </p>
                    </div>

                    <div class="mt-6 bg-gray-50 p-4 rounded-lg inline-block text-left">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-sm font-medium text-gray-500">Transaction ID</div>
                            <div class="text-sm text-gray-900">{{ $transactionId }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="text-sm font-medium text-gray-500">Request ID</div>
                            <div class="text-sm text-gray-900">#{{ $request->id ?? ($order->id ?? 'N/A') }}</div>
                        </div>
                        
                        @if(isset($request) && $request->academic_year && $request->term)
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="text-sm font-medium text-gray-500">Academic Year</div>
                            <div class="text-sm text-gray-900">{{ $request->academic_year }}</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="text-sm font-medium text-gray-500">Session</div>
                            <div class="text-sm text-gray-900">{{ $request->session ?? 'N/A' }}</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="text-sm font-medium text-gray-500">Term</div>
                            <div class="text-sm text-gray-900">{{ $request->term }}</div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div class="text-sm font-medium text-gray-500">Amount Paid</div>
                            <div class="text-sm text-gray-900">৳{{ number_format($request->amount, 2) }}</div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6">
                     
                            <a href="{{ route('student.dashboard') }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Go to Dashboard') }}
                            </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-payment-layout>