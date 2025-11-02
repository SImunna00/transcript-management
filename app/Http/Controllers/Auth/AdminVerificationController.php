<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminVerificationController extends Controller
{
    // This is a temporary solution for verification issues
    // Should be protected by admin middleware in routes
    public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && !$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return back()->with('success', 'User email has been manually verified.');
        }

        return back()->with('error', 'User not found or already verified.');
    }
}
