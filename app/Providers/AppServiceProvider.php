<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Pengaturan;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set bahasa Indonesia untuk Carbon (diffForHumans dll)
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // Kirim data pengaturan ke semua view
        view()->composer('*', function ($view) {
            $view->with('pengaturan', Pengaturan::first());
        });
    }
}
