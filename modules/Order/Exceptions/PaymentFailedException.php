<?php
namespace Modules\Order\Exceptions;
class PaymentFailedException extends \RuntimeException
{
    public static function dueInvalidToken() :PaymentFailedException
    {
        return new self('Payment failed due to invalid token');
    }
}
