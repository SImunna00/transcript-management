<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Complete Your Payment</h3>

                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Order Summary</h4>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="col-span-2 md:col-span-1">
                                <div class="text-sm font-medium text-gray-500">Document Type</div>
                                <div class="text-sm text-gray-900 capitalize">{{ $documentRequest->document_type }}
                                </div>
                            </div>

                            <div>
                                <div class="text-sm font-medium text-gray-500">Request ID</div>
                                <div class="text-sm text-gray-900">#{{ $documentRequest->id }}</div>
                            </div>

                            <div>
                                <div class="text-sm font-medium text-gray-500">Amount</div>
                                <div class="text-sm font-bold text-gray-900">
                                    ৳{{ number_format($documentRequest->amount, 2) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Payment Method</h4>

                        <div class="space-y-4">
                            <!-- Option 1: Direct SSLCommerz Integration -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-indigo-500 cursor-pointer">
                                <form action="{{ route('payment.initiate-document', $documentRequest->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-between">
                                        <span class="flex items-center">
                                            <img src="https://securepay.sslcommerz.com/public/image/SSLCommerz-Pay-With-logo-All-Size-01.png"
                                                alt="SSLCommerz" class="h-8 mr-2">
                                            <span>Pay with Credit/Debit Card, Mobile Banking or Internet Banking</span>
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Option 2: Manual Payment -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h5 class="font-medium">Manual Payment Instructions</h5>
                                <p class="text-sm mt-2">If you prefer manual payment, please follow these steps:</p>
                                <ol class="list-decimal list-inside text-sm mt-2 space-y-2">
                                    <li>Send the exact amount (৳{{ number_format($documentRequest->amount, 2) }}) to one
                                        of these numbers:
                                        <ul class="list-disc list-inside ml-4 mt-1">
                                            <li>bKash: 01XXXXXXXXX</li>
                                            <li>Nagad: 01XXXXXXXXX</li>
                                            <li>Rocket: 01XXXXXXXXX</li>
                                        </ul>
                                    </li>
                                    <li>Enter the transaction details below:</li>
                                </ol>

                                <form action="{{ route('payment.process', $documentRequest->id) }}" method="POST"
                                    class="mt-4">
                                    @csrf

                                    <div class="mb-4">
                                        <x-input-label for="payment_method" :value="__('Payment Method')" />
                                        <select id="payment_method" name="payment_method" required
                                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">Select payment method</option>
                                            <option value="bkash" {{ old('payment_method') == 'bkash' ? 'selected' : '' }}>bKash</option>
                                            <option value="nagad" {{ old('payment_method') == 'nagad' ? 'selected' : '' }}>Nagad</option>
                                            <option value="rocket" {{ old('payment_method') == 'rocket' ? 'selected' : '' }}>Rocket</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('payment_method')" class="mt-2" />
                                    </div>

                                    <div class="mb-4">
                                        <x-input-label for="transaction_id" :value="__('Transaction ID')" />
                                        <x-text-input id="transaction_id" class="block mt-1 w-full" type="text"
                                            name="transaction_id" :value="old('transaction_id')" required />
                                        <x-input-error :messages="$errors->get('transaction_id')" class="mt-2" />
                                    </div>

                                    <x-primary-button class="mt-2">
                                        {{ __('Submit Payment') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('document-requests.show', $documentRequest->id) }}"
                            class="text-indigo-600 hover:text-indigo-900">
                            &larr; Back to request details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>