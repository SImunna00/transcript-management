<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Please enter the 6-digit code sent to your NSTU email.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
    @endif

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('verification.verify') }}">
        @csrf

        <!-- OTP Input -->
        <div>
            <x-input-label for="otp" :value="__('Verification Code')" />
            <x-text-input 
                id="otp" 
                class="block mt-1 w-full text-center text-2xl"
                type="text"
                name="otp"
                maxlength="6"
                pattern="[0-9]{6}"
                placeholder="000000"
                required 
                autofocus 
            />
            <x-input-error :messages="$errors->get('otp')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <form method="POST" action="{{ route('verification.resend') }}" class="inline">
                @csrf
                <button type="submit"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Resend Code') }}
                </button>
            </form>

            <x-primary-button>
                {{ __('Verify Email') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>