<?php

namespace App\Providers;

use App\Services\BasePriceCalculatorService;
use Illuminate\Support\ServiceProvider;

class PromotionProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this
            ->app
            ->bind(
                BasePriceCalculatorService::class,
                function ($app, $unitPrice) {
                    return new BasePriceCalculatorService($unitPrice);
                });
    }
}
