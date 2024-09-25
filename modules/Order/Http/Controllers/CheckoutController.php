<?php
namespace Modules\Order\Http\Controllers;
use RuntimeException;
use Modules\Payment\PayBuddy;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Modules\Product\CartItemCollection;
use Modules\Order\Actions\PurchaseItems;
use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\Order\Exceptions\PaymentFailedException;
class CheckoutController extends Controller
{
    public function __construct(protected ProductStockManager $productStockManager , protected PurchaseItems $purchaseItems)
    {
    }
    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));
        try {
            $order = $this->purchaseItems->handle(
                items          : $cartItems ,
                paymentProvider: PayBuddy::make() ,
                paymentToken   : $request->input('payment_token') ,
                userId         : $request->user()->id);
        } catch (PaymentFailedException) {
            throw  ValidationException::withMessages(
                ['payment_token' => 'we could not complete your payment , please try again.']
            );
        }
        return response()->json([
            'order_url' => $order->url() ,
        ] , 201);


    }
}
