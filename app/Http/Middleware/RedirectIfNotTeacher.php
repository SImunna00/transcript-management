<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotTeacher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('teacher')->check()) {
            // Store the intended URL in the session if it's not a logout request
            if (!$request->is('teacher/logout') && $request->hasSession()) {
                $request->session()->put('url.intended', $request->url());
            }

            // Redirect to teacher login page
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}
