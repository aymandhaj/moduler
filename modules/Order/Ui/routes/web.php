<?php
use Illuminate\Support\Facades\Route;
Route::middleware('auth')->group(function() {
    Route::post('checkout' , \Modules\Order\Checkout\CheckoutController::class)->name('checkout');
    Route::get('orders/{order}', function(\Modules\Order\Order $order){
        return $order;
    })->name('orders.show');
});
