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
        $this->app->bind(
            BundleDiscountDecorator::class,
            function ($app, array $params) {
                return new BundleDiscountDecorator(
                    $params['calculator'],
                    $params['bundlePrice'],
                    $params['bundleQuantity']
                );
            }
        );
    }
}
