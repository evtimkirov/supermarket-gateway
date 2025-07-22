<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\PlaceOrderRequest;
use App\Http\Requests\API\ProductCalculationRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\BasePriceCalculatorService;
use App\Services\BundleDiscountDecorator;
use App\Services\OrderService;
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
        $items = array_count_values(str_split($request->input('sku_string')));
        $itemName = array_key_first($items);
        $itemCount = $items[$itemName];

        return response()
            ->json([
                'total_price' => OrderService::getProductTotalPriceWithPromotion(
                    Product::whereName($itemName)->first(),
                    $itemCount
                )
            ]);
    }

    /**
     * Place an order with the selected products and quantities
     *
     * @param PlaceOrderRequest $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function placeOrder(PlaceOrderRequest $request)
    {
        try {
            return OrderService::createOrderWithProducts($request->input('sku_string'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while saving the order.'
            ], 500);
        }
    }
}
