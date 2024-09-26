<?php

namespace Modules\Payment\Providers;

use Modules\Payment\PayBuddySdk;
use Modules\Payment\PaymentGateway;
use Modules\Payment\PayBuddyGateway;
use Illuminate\Support\ServiceProvider;
class PaymentServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'order');
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(PaymentGateway::class,fn () => new PayBuddyGateway(new PayBuddySdk()));

    }
}
