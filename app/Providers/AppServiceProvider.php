<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Products\Repository\EloquentProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Optionally bind repository concrete for reuse
        $this->app->bind(EloquentProductRepository::class, fn($app) => new EloquentProductRepository());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
