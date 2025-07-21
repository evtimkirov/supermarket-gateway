<?php

namespace App\Services;

/**
 * Interface for the product price and quantity calculation
 */
interface PriceCalculator
{
    public function calculate(int $quantity): int;
}
