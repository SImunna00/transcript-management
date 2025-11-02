{{-- Main Form Component with Loading States --}}
@props(['action', 'method' => 'POST', 'hasFiles' => false])

<form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'GET' : 'POST' }}"
      x-data="{ isSubmitting: false }"
      @submit="isSubmitting = true"
      {{ $hasFiles ? 'enctype="multipart/form-data"' : '' }}
      {{ $attributes }}>

    @csrf
    
    @if(strtolower($method) !== 'post' && strtolower($method) !== 'get')
        @method($method)
    @endif
    
    {{-- Loading Overlay when form is submitting --}}
    <div x-show="isSubmitting" 
         x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg flex flex-col items-center">
            <svg class="animate-spin h-12 w-12 text-indigo-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-700 font-medium">Processing your request...</p>
        </div>
    </div>
    
    {{ $slot }}
    
</form>

<style>
    [x-cloak] { display: none !important; }
</style>
