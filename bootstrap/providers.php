<?php

return [
    App\Providers\AppServiceProvider::class,
    \Modules\Order\infrastructure\Providers\OrderServiceProvider::class,
    \Modules\Payment\Providers\PaymentServiceProvider::class,
    \Modules\Product\Providers\ProductServiceProvider::class,
    \Modules\Shipment\Providers\ShipmentServiceProvider::class,
];
