<?php

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCreateOrderWithProduct(): void
    {
        $product = Product::factory()->create();
        $order = Order::factory()->create();
        $price = rand(10, 100);

        $totalPricePerItem = Order::createOrderWithProducts(
            $price,
            [
                'product_id' => $product->id,
                'quantity' => rand(1, 5),
            ],
            $order
        );

        $this->assertEquals($price, $totalPricePerItem);
    }
}
