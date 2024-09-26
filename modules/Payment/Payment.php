<?php
namespace Modules\Payment;
use App\Models\User;
use Modules\Order\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'payment_gateway'=>PaymentProvider::class
    ];

    public function order() :BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
