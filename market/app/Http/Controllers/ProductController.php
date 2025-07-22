<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Product listing page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function index()
    {
        return view(
            'index',
            [
                'products' => Product::with('promotion')->get()->toArray(),
                'orders' => Order::all()->sortDesc(),
            ]
        );
    }
}
