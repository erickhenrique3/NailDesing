<?php

namespace App\Providers;

use App\Models\Service;
use App\Observers\ServiceObserver;
use Domain\Auth\Contracts\AuthContract;
use Domain\Auth\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Service::observe(ServiceObserver::class);
    }
}
