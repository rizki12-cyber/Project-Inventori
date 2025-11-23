<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pengaturan;

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
        // Kirim data pengaturan ke semua view
        view()->composer('*', function ($view) {
            $view->with('pengaturan', Pengaturan::first());
        });
    }
}
