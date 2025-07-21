<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\BasePriceCalculatorService;
use App\Services\BundleDiscountDecorator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Handle API endpoint for calculation between the product price and the available promotion
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function calculate(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        return response()
            ->json(
                ['total_price' => $this->getProductTotalPriceWithPromotion($productId, $quantity)]
            );
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
