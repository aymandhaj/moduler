<?php
namespace Modules\Order\Events;
use Modules\User\UserDTo;
use Modules\Order\DTOs\OrderDto;
use Modules\Order\DTOs\OrderLineDto;
use Modules\Product\CartItemCollection;
readonly class OrderFulFilled
{

	public function __construct(

        public OrderDto $order,
        public UserDTo $user
    )
	{
	}
}
