{{-- Loading Button Component --}}
@props(['type' => 'primary', 'disabled' => false, 'loading' => false])

@php
    $baseClasses = 'inline-flex items-center px-4 py-2 border rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

    $typeClasses = [
        'primary' => 'bg-indigo-600 border-transparent text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:ring-indigo-500',
        'secondary' => 'bg-white border-gray-300 text-gray-700 hover:text-gray-500 focus:border-blue-300 active:bg-gray-50 focus:ring-blue-500',
        'success' => 'bg-green-600 border-transparent text-white hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:ring-green-500',
        'danger' => 'bg-red-600 border-transparent text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:ring-red-500',
        'warning' => 'bg-yellow-500 border-transparent text-white hover:bg-yellow-600 focus:bg-yellow-600 active:bg-yellow-700 focus:ring-yellow-500',
    ];

    $disabledClasses = 'opacity-50 cursor-not-allowed';
@endphp

<button {{ $disabled || $loading ? 'disabled' : '' }} {{ $attributes->merge(['type' => 'submit', 'class' => $baseClasses . ' ' . $typeClasses[$type] . (($disabled || $loading) ? ' ' . $disabledClasses : '')]) }}>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    @endif
    {{ $slot }}
</button>