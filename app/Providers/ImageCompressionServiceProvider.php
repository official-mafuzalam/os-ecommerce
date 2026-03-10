<?php

namespace App\Providers;

use App\Services\ImageCompressionService;
use Illuminate\Support\ServiceProvider;

class ImageCompressionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ImageCompressionService::class, function ($app) {
            return new ImageCompressionService();
        });
    }

    public function boot()
    {
        //
    }
}