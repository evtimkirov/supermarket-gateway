<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PlaceOrderRequest;
use App\Http\Requests\API\ProductCalculationRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\BasePriceCalculatorService;
use App\Services\BundleDiscountDecorator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Product controller for the API endpoints
 */
class ProductController extends Controller
{
    /**
     * Handle API endpoint for calculation between the product price and the available promotion
     *
     * @param ProductCalculationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function calculate(ProductCalculationRequest $request)
    {
        return response()
            ->json([
                'total_price' => $this->getProductTotalPriceWithPromotion(
                    $request->input('product_id'),
                    $request->input('quantity')
                )
            ]);
    }

    /**
     * Place an order with the selected products and quantities
     *
     * @param PlaceOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $totalOrderPrice = 0;
                $order = Order::create([
                    'total_price' => 0,
                ]);

                foreach ($request->input('products') as $item) {
                    $totalPricePerItem = $this->getProductTotalPriceWithPromotion(
                        $item['product_id'],
                        $item['quantity']
                    );

                    Order::createOrderWithProducts($totalPricePerItem, $item, $order);

                    $totalOrderPrice += $totalPricePerItem;
                }

                $order->update([
                    'total' => $totalOrderPrice,
                    'status' => 'completed',
                ]);

                return response()->json(['message' => 'The order has been placed.']);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while saving the order.'], 500);
        }
    }

    /**
     * Gets the product total price calculated with the current promotion
     *
     * @param $productId
     * @param $quantity
     * @return int
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function getProductTotalPriceWithPromotion($productId, $quantity)
    {
        $product = Product::findOrFail($productId);
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
            $dd = app()
                ->make(
                    BasePriceCalculatorService::class,
                    ['unitPrice' => $product->price]
                );
            $totalPrice = $dd->calculate($quantity);
        }

        return $totalPrice;
    }
}
