<?php
namespace Modules\Payment\Actions;
use Modules\Payment\Payment;
use Modules\Payment\PayBuddy;
use Modules\Order\Exceptions\PaymentFailedException;
use RuntimeException;
class CreatePaymentForOrder
{
    public function handel(int $orderId , int $userId , int $totalInCents , PayBuddy $payBuddy , string $paymentToken): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        try {
            $charge = $payBuddy->charge(token: $paymentToken , amountInCents: $totalInCents , statementDescription: 'module');
        } catch (RuntimeException) {
            throw  PaymentFailedException::dueInvalidToken();
        }

        return Payment::query()->create([
            'user_id' => $userId ,
            'order_id' => $orderId ,
            'total_in_cents' => $totalInCents ,
            'payment_id' => $charge['id'] ,
            'payment_gateway' => 'PayBuddy' ,
            'status' => 'paid'
        ]);
    }
}
