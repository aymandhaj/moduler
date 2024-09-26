<?php
namespace Modules\Order\DTOs;
use Modules\Payment\PayBuddySdk;
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
