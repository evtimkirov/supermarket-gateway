<?php

namespace App\Providers;

use App\Services\BundleDiscountDecorator;
use Illuminate\Support\ServiceProvider;

class BundleDiscountProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this
            ->app
            ->bind(
                BundleDiscountDecorator::class,
                function ($app, $calculator, $price, $quantity) {
                    return new BundleDiscountDecorator($calculator, $price, $quantity);
                });
    }
}
