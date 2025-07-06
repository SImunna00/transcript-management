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

class practice extends Controller
{
    //

    public function send()
    {
       $to="saifulislammunna08@gmail.com";
        $otp=12346;

      

        Mail::to($to)->send(new EmailVerification($otp));
    }
}
