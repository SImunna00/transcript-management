<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\EmailOtp;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class, 'regex:/^[a-zA-Z0-9._%+-]+@student\.nstu\.edu\.bd$/'],
                'studentid' => ['required', 'string', 'max:255', 'unique:users'],  // Add validation for studentid
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'email.regex' => 'Only NSTU student emails (@student.nstu.edu.bd) are allowed.',
                'studentid.unique' => 'This student ID is already registered.',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'studentid' => $request->studentid,  // Store the studentid
            'password' => Hash::make($request->password),
        ]);

        $otp = EmailOtp::generateOtp($user->email);

        try {
            Mail::to($user->email)->send(new EmailVerification($otp));
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP email: ' . $e->getMessage());
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

}