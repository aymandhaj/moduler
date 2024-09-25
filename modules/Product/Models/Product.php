<?php
namespace Modules\Product\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\ProductFactory;
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property int $price_in_cents
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $price
 * @method static \Modules\Product\Database\factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePriceInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price_in_cents','stock'];
    protected $casts = [
        'price_in_cents'=>'integer',
        'stock'=>'integer',
        'id'=>'integer',
        'name'=>'string'
    ];
    public function getPriceAttribute()
    {
        return $this->price_in_cents / 100;
    }
    public function setPriceAttribute($value)
    {
        $this->attributes['price_in_cents'] = $value * 100;
    }
    public function getStockAttribute($value)
    {
        return $value;
    }
    public function setStockAttribute($value)
    {
        $this->attributes['stock'] = $value;
    }
    protected static function newFactory() : ProductFactory
    {
        return new ProductFactory();
    }
}
