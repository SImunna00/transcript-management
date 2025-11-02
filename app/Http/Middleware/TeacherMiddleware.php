<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with the teacher guard
        if (!Auth::guard('teacher')->check()) {
            // Store intended URL if they're trying to access a protected route
            if ($request->is('teacher/*') || $request->is('teacher')) {
                session()->put('url.intended', $request->url());
            }
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}
