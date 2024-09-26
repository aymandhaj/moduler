<?php
namespace Modules\Order;
use NumberFormatter;
use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
/**
 *
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_price_in_cents
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereProductPriceInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderLine extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_price_in_cents',
        'quantity',
    ];
    protected $casts = [
        'order_id' => 'integer',
        'product_id' => 'integer',
        'product_price_in_cents' => 'integer',
        'quantity' => 'integer',
    ];
    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function product() : BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function totalInCents(): int
    {
        return $this->product_price_in_cents * $this->quantity;
    }
    public function total(): string
    {
        return (new NumberFormatter('en-US', NumberFormatter::CURRENCY))->formatCurrency($this->totalInCents() / 100, 'USD');
    }
    public function url(): string
    {
        return route('order::orders.show', $this->order);
    }
}
