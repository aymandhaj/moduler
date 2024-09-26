<?php
namespace Modules\Payment;
use RuntimeException;
use Modules\Payment\Exceptions\PaymentFailedException;
class PayBuddyGateway implements PaymentGateway
{
    public function __construct(
        protected PayBuddySdk $payBuddySdk
    )
    {
    }
    /**
     * @param paymentDetails $details
     * @return SuccessfulPayment
     * @throws PaymentFailedException
     */
    public function charge(PaymentDetails $details): SuccessfulPayment
    {
        try {
            $charge = $this->payBuddySdk->charge(
                token               : $details->token ,
                amountInCents       : $details->amountInCents ,
                statementDescription: $details->statementDescriptor
            );
        } catch (RuntimeException $exception) {
            throw  PaymentFailedException::dueInvalidToken($exception->getMessage());
        }
        return new SuccessfulPayment(
            id             : $charge['id'] ,
            amountInCents  : $charge['amount_in_cents'] ,
            paymentProvider: $this->id()
        );
    }
    public function id(): PaymentProvider
    {
        return PaymentProvider::PayBuddy;
    }
}
