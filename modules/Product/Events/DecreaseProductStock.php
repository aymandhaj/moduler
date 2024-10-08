<?php
namespace Modules\Product\Events;
use Modules\Order\Checkout\OrderFulFilled;
use Modules\Product\Warehouse\ProductStockManager;
class DecreaseProductStock
{
    public function __construct(protected ProductStockManager $productStockManager)
    {
    }
    public function handle(OrderFulFilled $event): void
    {
        foreach ($event->order->lines as $orderLine) {
            $this->productStockManager->decrementStock($orderLine->productId , $orderLine->quantity);
        }


    }
}
