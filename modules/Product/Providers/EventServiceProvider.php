<?php
namespace Modules\Product\Providers;
class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    protected $listen = [
        \Modules\Order\Events\OrderFulFilled::class => [
            \Modules\Product\Events\DecreaseProductStock::class,
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
