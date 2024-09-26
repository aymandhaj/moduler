<?php
namespace Modules\Order\DTOs;
use Modules\Payment\PayBuddy;
readonly  class PendingPayment
{
	public function __construct(
        public PayBuddy $paymentProvider,
        public string $paymentToken

    )
	{
	}
}
