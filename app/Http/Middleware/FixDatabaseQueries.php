<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Connection;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FixDatabaseQueries
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Fix for MySQL performance_schema issues in XAMPP
        \Illuminate\Support\Facades\DB::beforeExecuting(function ($query, $bindings, $connection) {
            // If the query is trying to access performance_schema.session_status table
            if (stripos($query, 'performance_schema.session_status') !== false) {
                // Return a fake query that will return a simple value
                return "SELECT 1 as `Value`";
            }

            return $query;
        });

        return $next($request);
    }
}
