<?php
namespace Http\Controllers;
use Tests\TestCase;
use Modules\Payment\Payment;
use Modules\Payment\PayBuddy;
use Modules\Order\Models\Order;
use Database\Factories\UserFactory;
use Modules\Order\Models\OrderLine;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Product\Database\factories\ProductFactory;
class CheckoutControllerTest extends TestCase
{
    use DatabaseMigrations;
    #[Test]
    public function it_successfully_creates_an_order(): void
    {
        $user = UserFactory::new()->create();
        $products = ProductFactory::new()->count(2)->create(
            new Sequence([
                'name' => 'expensive air fryer' ,
                'price_in_cents' => 10000 ,
                'stock' => 10
            ] ,
                [
                    'name' => 'mackbok air fryer' ,
                    'price_in_cents' => 10000 ,
                    'stock' => 10
                ])
        );
        $paymentToken = PayBuddy::validToken();
        Log::info(3333434343);
        $response = $this->actingAs($user)
            ->post(route('order::checkout') , [
                'payment_token' => $paymentToken ,
                'products' => [
                    ['id' => $products->first()->id , 'quantity' => 3] ,
                    ['id' => $products->last()->id , 'quantity' => 3]
                ]
            ]);

        $order = Order::query()->latest('id')->first();
        $response
            ->assertJson([
                'order_url' => $order->url()
            ])
            ->assertStatus(201);


        // order

        $this->assertTrue($order->user->is($user));
        $this->assertEquals(60000 , $order->total_in_cents);
        $this->assertEquals('completed' , $order->status);
        // payment
        $payment = $order->lastPayment;

        $this->assertTrue($order->user->is($user));
        $this->assertEquals('paid' , $payment->status);
        $this->assertEquals('PayBuddy' , $payment->payment_gateway);
//        $this->assertEquals(36, $payment->payment_id);
        $this->assertEquals(60000 , $payment->total_in_cents);
        $this->assertTrue($payment->user->is($user));

        $this->assertCount(2 , $order->lines);
        foreach ($products as $product) {
            $orderLine = $order->lines->where('product_id' , $product->id)->first();

            $this->assertEquals($product->price_in_cents , $orderLine->product_price_in_cents);
            $this->assertEquals(3 , $orderLine->quantity);
        }
        $products = $products->fresh();
        $this->assertEquals(7 , $products->first()->stock);
        $this->assertEquals(7 , $products->last()->stock);
    }

    #[Test]
    public function it_fails_with_an_invalid_token(): void
    {
        $user = UserFactory::new()->create();
        $products = ProductFactory::new()->count(2)->create();
        $paymentToken = PayBuddy::invalidToken();
        $response = $this->actingAs($user)
            ->postJson(route('order::checkout') , [
                'payment_token' => $paymentToken ,
                'products' => [
                    ['id' => $products->first()->id , 'quantity' => 3] ,
                    ['id' => $products->first()->id , 'quantity' => 3]
                ]
            ]);
        $response->assertStatus(422)
        ->assertJsonValidationErrors(['payment_token']);
        $this->assertEquals(0,Order::query()->count());

    }
}
