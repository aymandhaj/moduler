<?php
namespace Modules\Order\Checkout;
use Modules\User\UserDTo;
use Modules\Order\Contracts\OrderDto;
readonly class OrderFulFilled
{

	public function __construct(

        public OrderDto $order,
        public UserDTo $user
    )
	{
	}
}
