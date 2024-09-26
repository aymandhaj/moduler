<?php
namespace Modules\Payment\Exceptions;
class PaymentFailedException extends \RuntimeException
{
    public static function dueInvalidToken() :PaymentFailedException
    {
        return new self('Payment failed due to invalid token');
    }
}
