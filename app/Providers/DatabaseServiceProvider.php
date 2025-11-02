<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // 
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Set the default string length for schema operations
        Schema::defaultStringLength(191);

        // Override the database status methods with a simpler implementation
        DB::beforeExecuting(function ($query, $bindings, $connection) {
            // If the query is trying to access performance_schema.session_status table
            if (stripos($query, 'performance_schema.session_status') !== false) {
                // Return a fake query that will return a simple value
                return "SELECT 1 as `Value`";
            }

            return $query;
        });

        
    }
}
