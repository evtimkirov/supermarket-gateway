<?php

namespace App\Services;

/**
 * Price and quantity calculations
 */
class BasePriceCalculatorService implements PriceCalculator
{
    /**
     * Constructor with the product price
     */
    public function __construct(public $unitPrice)
    {}

    /**
     * Calculation with the item price
     *
     * @param int $quantity
     * @return int
     */
    public function calculate(int $quantity): int
    {
        return $quantity * $this->unitPrice;
    }
}
