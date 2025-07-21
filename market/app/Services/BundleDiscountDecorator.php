<?php

namespace App\Services;

/**
 * Decorator class of the BasePriceCalculatorService.
 * Change the prices depending on the promotion.
 */
class BundleDiscountDecorator implements PriceCalculator
{
    /**
     * Constructor with the $calculator abstraction
     *
     * @param PriceCalculator $calculator
     * @param int $bundlePrice
     * @param int $bundleQuantity
     */
    public function __construct(
        protected PriceCalculator $calculator,
        protected int $bundlePrice,
        protected int $bundleQuantity
    ) {}

    /**
     * Calculate the promotion with the basic price
     *
     * @param int $quantity
     * @return int
     */
    public function calculate(int $quantity): int
    {
        $bundlesCount = intdiv($quantity, $this->bundleQuantity); // Number of matches
        $remainder = $quantity % $this->bundleQuantity; // If zero than promotion

        return $bundlesCount * $this->bundlePrice + $remainder * $this->calculator->unitPrice;
    }
}
