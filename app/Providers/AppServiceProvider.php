<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Force HTTPS when not on localhost (handles Railway, Heroku, etc.)
        if (!$this->app->environment('local')) {
            URL::forceScheme('https');
        }

        // Also force HTTPS if the request came through a proxy with X-Forwarded-Proto
        if (request()->header('X-Forwarded-Proto') === 'https' ||
            str_contains(config('app.url', ''), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
