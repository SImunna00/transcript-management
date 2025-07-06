<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {   

        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@student\.nstu\.edu\.bd$/'
            ],
            'password' => ['required', 'string'],
        ], [
            'email.regex' => 'Only NSTU student emails (@student.nstu.edu.bd) are allowed.'
        ]);

        // $user = Auth::user();
        // if (!$user->hasVerifiedEmail()) {
        //     Auth::logout();
        //     return redirect()->route('verification.notice')
        //                     ->with('status', 'Please verify your email before logging in.');
        // }
        $request->authenticate();

        $request->session()->regenerate();

       return redirect()->route('student.dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
