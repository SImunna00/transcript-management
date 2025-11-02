<x-guest-layout>
    <div class="min-h-screen w-full py-8 px-4 bg-gray-100">
        <div class="w-full max-w-2xl px-6 py-8 bg-white rounded-lg mx-auto shadow-md overflow-visible mt-2">
            <h2 class="text-lg font-bold text-center mb-6 text-gray-800">Student Registration</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Personal Information Section -->
                <div class="mb-6">
                    <div class="space-y-4">
                        <!-- Name -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="name" :value="__('Full Name')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <x-text-input id="name"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="Enter your full name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Phone Number -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="phone" :value="__('Phone Number')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <x-text-input id="phone"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    type="text" name="phone" :value="old('phone')" required autocomplete="phone"
                                    placeholder="e.g. 01700000000" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="mb-6">
                    <div class="space-y-4">
                        <!-- Email Address -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="email" :value="__('Student Email')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <x-text-input id="email"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    type="email" name="email" :value="old('email')" required autocomplete="username"
                                    placeholder="yourid@student.nstu.edu.bd" />
                                <p class="text-xs text-gray-500 mt-1">Only @student.nstu.edu.bd</p>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Student ID -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="student_id" :value="__('Student ID')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <x-text-input id="student_id"
                                    class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    type="text" name="studentid" :value="old('studentid')" required
                                    autocomplete="studentid" placeholder="e.g. ASH1901XXX" />
                                <x-input-error :messages="$errors->get('studentid')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Session -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="session" :value="__('Session')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <select id="session" name="session"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled selected>Select your session</option>
                                    @for ($year = date('Y'); $year >= 2010; $year--)
                                        <option value="{{ $year }}-{{ $year + 1 }}" {{ old('session') == $year . '-' . ($year + 1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('session')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Academic Year -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="academic_year_id" :value="__('Academic Year')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <select id="academic_year_id" name="academic_year_id"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled selected>Select your academic year</option>
                                    <option value="1" {{ old('academic_year_id') == '1' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2" {{ old('academic_year_id') == '2' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3" {{ old('academic_year_id') == '3' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4" {{ old('academic_year_id') == '4' ? 'selected' : '' }}>4th Year</option>
                                </select>
                                <x-input-error :messages="$errors->get('academic_year_id')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Term -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="term_id" :value="__('Term')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <select id="term_id" name="term_id"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    required>
                                    <option value="" disabled selected>Select your term</option>
                                    <option value="1" {{ old('term_id') == '1' ? 'selected' : '' }}>1st Term</option>
                                    <option value="2" {{ old('term_id') == '2' ? 'selected' : '' }}>2nd Term</option>
                                </select>
                                <x-input-error :messages="$errors->get('term_id')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="mb-6">
                    <div class="space-y-4">
                        <!-- Password -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="password" :value="__('Password')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <div class="relative">
                                    <x-text-input id="password"
                                        class="block w-full pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        type="password" name="password" required autocomplete="new-password" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" id="togglePassword"
                                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor" id="eyeIcon">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Min 8 chars with letters & numbers</p>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="flex flex-col sm:flex-row sm:items-center sm:gap-4 gap-2">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="sm:w-40 sm:flex-shrink-0 font-medium text-gray-700" />
                            <div class="flex-1">
                                <div class="relative">
                                    <x-text-input id="password_confirmation"
                                        class="block w-full pr-10 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        type="password" name="password_confirmation" required autocomplete="new-password" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" id="toggleConfirmPassword"
                                            class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor" id="eyeIconConfirm">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="flex flex-col items-center justify-between mt-8 gap-4">
                    <x-primary-button class="w-full py-3 px-4 text-base">
                        {{ __('Register') }}
                    </x-primary-button>
                    <div class="w-full text-center">
                        <a class="text-sm text-indigo-600 hover:text-indigo-900 font-medium transition duration-150 ease-in-out"
                            href="{{ route('login') }}">
                            Already have an account? Login
                        </a>
                    </div>
                </div>

                <!-- JavaScript for Password Toggle -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Password toggle
                        const togglePassword = document.getElementById('togglePassword');
                        const password = document.getElementById('password');
                        const eyeIcon = document.getElementById('eyeIcon');

                        togglePassword.addEventListener('click', function () {
                            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                            password.setAttribute('type', type);
                        });

                        // Confirm Password toggle
                        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
                        const passwordConfirm = document.getElementById('password_confirmation');
                        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

                        toggleConfirmPassword.addEventListener('click', function () {
                            const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
                            passwordConfirm.setAttribute('type', type);
                        });
                    });
                </script>
            </form>
        </div>
    </div>
</x-guest-layout>