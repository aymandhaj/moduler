<?php
namespace Modules\Order\Actions;
use Modules\User\UserDTo;
use Modules\Order\Models\Order;
use Modules\Order\DTOs\OrderDto;
use Illuminate\Events\Dispatcher;
use Modules\Order\DTOs\PendingPayment;
use Modules\Product\CartItemCollection;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderFulFilled;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\Payment\Actions\CreatePaymentForOrder;
class PurchaseItems
{
    public function __construct(
        protected ProductStockManager   $productStockManager ,
        protected CreatePaymentForOrder $createPaymentForOrder ,
        protected DatabaseManager       $databaseManager ,
        protected Dispatcher            $events
    )
    {
    }
    public function handle(CartItemCollection $items , PendingPayment $pendingPayment , UserDTo $user) : OrderDto
    {

        /** @var OrderDto $order */
        $order = $this->databaseManager->transaction(function() use ($pendingPayment , $user , $items) {
            $order = Order::startForUser($user->id);
            $order->addLinesFromCartItems($items);
            $order->fulfill();
            $this->createPaymentForOrder->handel(
                orderId     : $order->id ,
                userId      : $user->id ,
                totalInCents: $items->totalInCents() ,
                paymentGateway    : $pendingPayment->paymentProvider ,
                paymentToken: $pendingPayment->paymentToken
            );
            return OrderDto::fromEloquentModel($order) ;
        });
        $this->events->dispatch(
            new OrderFulFilled(order: $order,  user: $user)
        );
        return $order;
    }
}
