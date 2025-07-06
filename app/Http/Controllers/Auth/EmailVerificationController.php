<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;

use App\Models\EmailOtp;

use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{

    public function showVerificationForm()
    {
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $user = Auth::user();
        $emailOtp = EmailOtp::where('email', $user->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$emailOtp) {
            return back()->withErrors([
                'otp' => 'The verification code is invalid or has expired.',
            ]);
        }

        $user->markEmailAsVerified();
        $emailOtp->delete();

        return redirect()->route('student.dashboard')
            ->with('status', 'Your email has been verified!');
    }


    public function resend(Request $request)
    {
        $user = Auth::user();
        $otp = EmailOtp::generateOtp($user->email);
        try {
            Mail::to($user->email)->send(new EmailVerification($otp));
            \Log::info('Resent OTP email to: ' . $user->email);
        } catch (\Exception $e) {
            \Log::error('Failed to resend OTP email: ' . $e->getMessage());
        }

        return back()->with('status', 'A new verification code has been sent!');
    }


}
