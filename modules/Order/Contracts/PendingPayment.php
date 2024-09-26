<?php
namespace Modules\Order\Contracts;
use Modules\Payment\PaymentGateway;
readonly  class PendingPayment
{
	public function __construct(
        public PaymentGateway $paymentProvider,
        public string      $paymentToken

    )
	{
	}
}
