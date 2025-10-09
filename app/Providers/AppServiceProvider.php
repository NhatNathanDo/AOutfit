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
        // Optionally bind repository concrete for reuse
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
