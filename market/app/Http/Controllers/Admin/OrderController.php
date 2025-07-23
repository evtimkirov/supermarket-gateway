<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orders\ChangeStatusRequest;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.orders.index',
            ['orders' => Order::all()->sortDesc()]
        );
    }

    /**
     * Update order status
     *
     * @param ChangeStatusRequest $request
     * @param Order $order
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(ChangeStatusRequest $request, Order $order)
    {
        $validated = $request->validated();

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status updated.');
    }
}
