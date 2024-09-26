<?php
namespace Modules\Order\Checkout;
use Illuminate\Support\Facades\Mail;
class SendOrderConfirmationMail
{
    public function handle(OrderFulFilled $event) :void
    {
        Mail::to($event->user->email)->send(new OrderReceived($event->order));
    }
}
