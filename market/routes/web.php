<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);

// Admin routes
Route::prefix('admin')
    ->middleware(['web', 'auth'])
    ->group(base_path('routes/admin.php'));
