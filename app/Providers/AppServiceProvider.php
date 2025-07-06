<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Include teacher auth routes
        $this->loadRoutesFrom(base_path('routes/teacher-auth.php'));

        // Share $errors variable with all views
        view()->share('errors', \Illuminate\Support\Facades\View::shared('errors', fn() => session()->get('errors', new \Illuminate\Support\ViewErrorBag)));
    }
}
