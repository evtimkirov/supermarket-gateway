<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::inRandomOrder()->limit(2)->get();
        $orders = Order::factory()->count(3)->create();

        foreach ($orders as $order) {
            foreach ($products as $product) {
                $quantity = rand(1, 5);
                $finalPrice = $quantity * $product->price;

                $order->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'final_price' => $finalPrice,
                ]);
            }
        }
    }
}
