<?php
namespace Modules\Order\Http\Controllers;
use Modules\User\UserDTo;
use Modules\Payment\PaymentGateway;
use App\Http\Controllers\Controller;
use Modules\Order\DTOs\PendingPayment;
use Modules\Product\CartItemCollection;
use Modules\Order\Actions\PurchaseItems;
use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Payment\Exceptions\PaymentFailedException;
class CheckoutController extends Controller
{
    public function __construct(
        protected PaymentGateway $paymentGateway ,
        protected PurchaseItems $purchaseItems
    )
    {
    }
    public function __invoke(CheckoutRequest $request)
    {
        $cartItems = CartItemCollection::fromCheckoutData($request->input('products'));
        $pendingPayment = new PendingPayment($this->paymentGateway, $request->input('payment_token'));
        $userDto = UserDTo::fromEloquentModel($request->user());
        try {
            $order = $this->purchaseItems->handle(
                items         : $cartItems ,
                pendingPayment: $pendingPayment ,
                user          : $userDto ,
            );
        } catch (PaymentFailedException) {
            throw  ValidationException::withMessages(
                ['payment_token' => 'we could not complete your payment , please try again.']
            );
        }
        return response()->json([
            'order_url' => $order->url ,
        ] , 201);


    }
}
