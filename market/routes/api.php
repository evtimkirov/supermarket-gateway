<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckToken;
use App\Http\Controllers\ProductController;

Route::middleware(CheckToken::class)->group(function () {
    Route::get(
        '/products',
        [
            ProductController::class,
            'index',
        ]
    );
});
