<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
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
        // Tampilan pagination memakai gaya Bootstrap 5, selaras dengan
        // seluruh antarmuka E-KONSUL yang berbasis Bootstrap 5.
        Paginator::useBootstrapFive();
    }
}
