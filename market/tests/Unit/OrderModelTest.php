<?php

use App\Models\Order;
use App\Models\Product;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    /**
     * Test the createOrderWithProduct method from the Order model
     *
     * @return void
     */
    public function testCreateOrderWithProduct(): void
    {
        $product = Product::factory()->create()->first();
        $order = Order::factory()->create();
        $price = rand(10, 100);
        $quantity = rand(1, 5);

        $totalPricePerItem = Order::createOrderWithProducts(
            $price,
            $product,
            $order,
            $quantity
        );

        $this->assertEquals($price, $totalPricePerItem);
    }
}
