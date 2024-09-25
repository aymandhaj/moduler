<?php
namespace Modules\Product;
use Modules\Product\Models\Product;
readonly class ProductDto
{
    public function __construct(public int $id,public int $priceInCents, public int $unitINStock)
    {
    }
    public static function fromEloquentModel(Product $product) : ProductDto
    {
        return new self(
            id: $product->id,
            priceInCents: $product->price_in_cents,
            unitINStock: $product->stock
        );
    }

}
