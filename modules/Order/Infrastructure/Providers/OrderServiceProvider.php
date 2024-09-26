<?php

namespace Modules\Order\Infrastructure\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
class OrderServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->loadViewsFrom(__DIR__.'/../Ui/Views','order');
        Blade::anonymousComponentPath(__DIR__.'/../Ui/Views/Components','order');
        Blade::componentNamespace('Modules\\Order\\Ui\\ViewComponents', 'order');

    }
}
