<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        // Check which guard is being used, if any
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // For teacher guard, redirect to teacher dashboard
                if ($guard === 'teacher') {
                    return redirect('/teacher/dashboard');
                }

                // For admin guard
                if ($guard === 'admin') {
                    return redirect('/admin/dashboard');
                }

                // For web guard (used by Breeze for students), redirect to student dashboard
                if ($guard === null || $guard === 'web') {
                    return redirect('/student/dashboard');
                }
            }
        }

        return $next($request);
    }
}
