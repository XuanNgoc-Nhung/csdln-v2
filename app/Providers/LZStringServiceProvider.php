<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LZCompressor\LZString;

class LZStringServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('lzstring', function ($app) {
            return new LZString();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 