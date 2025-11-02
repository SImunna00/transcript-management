<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with the web guard (student)
        if (!Auth::guard('web')->check()) {
            // Only redirect if it's a student route
            if ($request->is('student/*') || $request->is('student')) {
                session()->put('url.intended', $request->url());
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
