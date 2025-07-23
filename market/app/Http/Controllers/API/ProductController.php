<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PlaceOrderRequest;
use App\Http\Requests\API\ProductCalculationRequest;
use App\Models\Product;
use App\Services\OrderService;
use App\Helpers\SkuParser;
use Illuminate\Support\Facades\Log;

/**
 * Product controller for the API endpoints
 */
class ProductController extends Controller
{
    /**
     * Handle API endpoint for calculation between the product price and the available promotion
     *
     * @param ProductCalculationRequest $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function calculate(ProductCalculationRequest $request, OrderService $orderService)
    {
        $items = SkuParser::parse($request->input('sku_string'));
        $itemName = array_key_first($items);
        $itemCount = $items[$itemName];

        return response()
            ->json([
                'total_price' => $orderService->getProductTotalPriceWithPromotion(
                    Product::whereName($itemName)->first(),
                    $itemCount
                )
            ]);
    }

    /**
     * Place an order with the selected products and quantities
     *
     * @param PlaceOrderRequest $request
     * @param OrderService $orderService
     * @return \Illuminate\Http\JsonResponse
     */
    public function placeOrder(PlaceOrderRequest $request, OrderService $orderService)
    {
        try {
            $orderService->createOrderWithProducts($request->input('sku_string'));

            return response()->json(['message' => 'The order has been placed.']);
        } catch (\Exception $e) {
            Log::error('Order failed', ['exception' => $e]);

            return response()->json([
                'error' => 'An error occurred while saving the order.'
            ], 500);
        }
    }
}
