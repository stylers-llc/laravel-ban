<?php

namespace Stylers\LaravelBan\Providers;

use Illuminate\Support\ServiceProvider;
use Stylers\LaravelBan\Builders\BanBuilder;
use Stylers\LaravelBan\Contracts\Builders\BanBuilderInterface;
use Stylers\LaravelBan\Contracts\Models\BanInterface;
use Stylers\LaravelBan\Contracts\Services\BanServiceInterface;
use Stylers\LaravelBan\Models\Ban;
use Stylers\LaravelBan\Observers\BanObserver;
use Stylers\LaravelBan\Services\BanService;

/**
 * Class BanServiceProvider
 * @package Stylers\LaravelBan\Providers
 */
class BanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../config' => config_path(),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang'),
        ]);

        $this->app->make(BanInterface::class)->observe(new BanObserver());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BanInterface::class, Ban::class);
        $this->app->bind(BanBuilderInterface::class, BanBuilder::class);
        $this->app->singleton(BanServiceInterface::class, BanService::class);
    }
}
