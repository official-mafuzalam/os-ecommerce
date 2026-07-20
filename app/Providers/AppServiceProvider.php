<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        $theme = setting('site_theme', 'fashion');
        $themeViewPath = resource_path("views/themes/{$theme}");

        if (is_dir($themeViewPath)) {
            View::getFinder()->prependLocation($themeViewPath);
        }
    }
}
