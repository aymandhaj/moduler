<?php
namespace Modules\Order\infrastructure\Providers;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        \Modules\Order\Checkout\OrderFulFilled::class => [
            \Modules\Order\Checkout\SendOrderConfirmationMail::class,
        ],
    ];
    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
    public function boot(): void
    {
        parent::boot();
    }
}
