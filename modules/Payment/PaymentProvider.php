<?php
namespace Modules\Payment;
enum PaymentProvider : string {
    case PayBuddy = 'PayBuddy';
    case InMemory = 'in_memory';

}
