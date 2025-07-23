<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Helpers\SkuParser;

/**
 * The service responsibilities are for help the
 * API product controller to calculate the product prices
 * with the promotions and to create the order with all the selected products.
 */
class OrderService
{
    /**
     * Create an order with all the selected items and applied the promotions
     *
     * @param $skuString
     * @return void
     */
    public function createOrderWithProducts($skuString)
    {
        DB::transaction(function () use ($skuString) {
            $totalOrderPrice = 0;
            $order = Order::create(['total_price' => 0]);

            $items = SkuParser::parse($skuString);
            foreach ($items as $name => $quantity) {
                $product = Product::whereName($name)->first();

                $totalPricePerItem = $this->getProductTotalPriceWithPromotion(
                    $product,
                    $quantity
                );

                Order::createOrderWithProducts(
                    $totalPricePerItem,
                    $product,
                    $order,
                    $quantity
                );

                $totalOrderPrice += $totalPricePerItem;
            }

            $order->update([
                'total' => $totalOrderPrice,
                'status' => 'completed',
            ]);
        });
    }

    /**
     * Gets the product total price calculated with the current promotion
     *
     * @param $product
     * @param $quantity
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getProductTotalPriceWithPromotion($product, $quantity)
    {
        $promotion = $product->promotion()->first();

        if ($promotion) {
            $productBundlePriceService = app()->make(
                BundleDiscountDecorator::class,
                [
                    'calculator' => new BasePriceCalculatorService($product->price),
                    'bundlePrice' => $promotion->total,
                    'bundleQuantity' => $promotion->quantity,
                ]
            );

            $totalPrice = $productBundlePriceService->calculate($quantity);
        } else {
            $calculatedBasePrice = app()
                ->make(
                    BasePriceCalculatorService::class,
                    ['unitPrice' => $product->price]
                );

            $totalPrice = $calculatedBasePrice->calculate($quantity);
        }

        return $totalPrice;
    }
}
