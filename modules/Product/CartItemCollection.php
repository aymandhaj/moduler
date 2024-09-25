<?php
namespace Modules\Product;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;
class CartItemCollection
{
    /**
     * CartItemCollection constructor.
     * @param Collection $items
     */
    public function __construct(protected Collection $items)
    {
    }
    public static function fromCheckoutData(array $data): CartItemCollection
    {
        /** @var \Illuminate\Support\Collection<CartItem> $cartitems */
        $cartitems = collect($data)->map(function($productDetails) {
            return new CartItem(
                product:ProductDto::fromEloquentModel(Product::query()->find($productDetails['id'])),
                quantity:  $productDetails['quantity']);
        });
        return new self($cartitems);
    }
    public function totalInCents()
    {
        return $this->items->sum(fn (CartItem $cartItem) => $cartItem->product->priceInCents * $cartItem->quantity);
    }

    /**
     * @return Collection<CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
