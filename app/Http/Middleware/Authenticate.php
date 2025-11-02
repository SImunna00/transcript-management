<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // If the request path is for teacher routes
            if ($request->is('teacher/*') || $request->is('teacher')) {
                // Explicitly redirect to the teacher login URL using a direct URL to avoid routing issues
                return '/teacher/login';
            }

            // If the request path is for admin routes
            if ($request->is('admin/*') || $request->is('admin')) {
                return '/admin/login';
            }

            // For student routes, use Laravel's login route
            return route('login');
        }

        return null;
    }
}
