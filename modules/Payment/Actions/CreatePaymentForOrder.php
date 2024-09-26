<?php
namespace Modules\Payment\Actions;
use RuntimeException;
use Modules\Payment\Payment;
use Modules\Payment\PaymentDetails;
use Modules\Payment\PaymentGateway;
use Modules\Payment\Exceptions\PaymentFailedException;
class CreatePaymentForOrder
{
    public function handel(int $orderId , int $userId , int $totalInCents , PaymentGateway $paymentGateway , string $paymentToken): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        $charge = $paymentGateway->charge(
            details: new PaymentDetails(
                token              : $paymentToken ,
                amountInCents      : $totalInCents ,
                statementDescriptor: "Module"
            )
        );
        return Payment::query()->create([
            'user_id' => $userId ,
            'order_id' => $orderId ,
            'total_in_cents' => $totalInCents ,
            'payment_id' => $charge->id ,
            'payment_gateway' => $charge->paymentProvider ,
            'status' => 'paid'
        ]);
    }
}
