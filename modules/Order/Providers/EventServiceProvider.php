<?php
namespace Modules\Order\Providers;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        \Modules\Order\Events\OrderFulFilled::class => [
            \Modules\Order\Events\SendOrderConfirmationMail::class,
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
