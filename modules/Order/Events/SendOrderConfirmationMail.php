<?php
namespace Modules\Order\Events;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\OrderReceived;
class SendOrderConfirmationMail
{
    public function handle(OrderFulFilled $event) :void
    {
         Mail::to($event->user->email)->send(new OrderReceived($event->order->localizedTotal));
    }
}
