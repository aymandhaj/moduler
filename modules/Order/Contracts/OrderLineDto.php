<?php
namespace Modules\Order\Contracts;
use Modules\Order\OrderLine;
use Illuminate\Support\Collection;
class OrderLineDto
{
    public function __construct(
        public int    $productId,
        public int $productPriceInCents,
        public int $quantity,

    )
    {
    }

    public static function fromEloquentModel(OrderLine $orderLine): self
    {
        return new self(productId: $orderLine->product_id, productPriceInCents: $orderLine->product_price_in_cents, quantity: $orderLine->quantity);
    }

    public static function fromEloquentCollection(Collection $orderLines): array
    {
        return $orderLines->map(fn(OrderLine $orderLine) => self::fromEloquentModel($orderLine))->all();
    }
}
