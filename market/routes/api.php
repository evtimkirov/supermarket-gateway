<?php

use App\Http\Controllers\API\ProductController;
use App\Http\Middleware\CheckToken;
use Illuminate\Support\Facades\Route;

Route::middleware(CheckToken::class)
    ->group(function () {
        Route::post(
            'products/calculate',
            [
                ProductController::class,
                'calculate',
            ]
        );
});
