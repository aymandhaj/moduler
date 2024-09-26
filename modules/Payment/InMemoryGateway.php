<?php
namespace Modules\Payment;
use Illuminate\Support\Str;
class InMemoryGateway implements PaymentGateway
{
    public function charge(PaymentDetails $details) : SuccessfulPayment{
        return new SuccessfulPayment(
            id: (string) Str::uuid(),
            amountInCents: $details->amountInCents,
            paymentProvider: $this->id()
        );
    }

    public function id() : PaymentProvider
    {
        PaymentProvider::InMemory;
    }
}
