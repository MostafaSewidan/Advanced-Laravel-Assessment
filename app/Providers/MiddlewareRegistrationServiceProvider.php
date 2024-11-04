<?php

namespace App\Providers;

use App\Http\Middleware\{LoggingMiddleware,RateLimiterMiddleware};
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;

class MiddlewareRegistrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //this middlewares registered global
        $this->app->make(Kernel::class)->pushMiddleware(LoggingMiddleware::class);
        $this->app->make(Kernel::class)->pushMiddleware(RateLimiterMiddleware::class);
    }
}
