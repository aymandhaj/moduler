<?php
namespace Modules\Order\Actions;
use Modules\Payment\PayBuddy;
use Modules\Order\Models\Order;
use Illuminate\Support\Facades\Log;
use Modules\Product\CartItemCollection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\Payment\Actions\CreatePaymentForOrder;
use Modules\Order\Exceptions\PaymentFailedException;
class PurchaseItems
{
    public function __construct(
        protected ProductStockManager   $productStockManager ,
        protected CreatePaymentForOrder $createPaymentForOrder,
        protected DatabaseManager       $databaseManager
    )
    {
    }
    public function handle(CartItemCollection $items , PayBuddy $paymentProvider , string $paymentToken , int $userId): Order
    {
        $orderTotalInCents = $items->totalInCents();
        return $this->databaseManager->transaction(function() use ($paymentToken , $paymentProvider , $items  , $userId) {
            $order = Order::startForUser($userId );
            $order->addLinesFromCartItems($items);
            $order->fulfill();

            foreach ($items->items() as $cartItem) {
                $this->productStockManager->decrementStock($cartItem->product->id , $cartItem->quantity);
            }
            $this->createPaymentForOrder->handel(
                orderId     : $order->id ,
                userId      : $userId ,
                totalInCents: $items->totalInCents(),
                payBuddy    : $paymentProvider ,
                paymentToken: $paymentToken
            );
            return $order;
        });
    }
}
