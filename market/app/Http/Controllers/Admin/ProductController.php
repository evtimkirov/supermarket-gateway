<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\DeleteRequest;
use App\Http\Requests\Admin\Products\EditRequest;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Product;
use App\Models\Promotion;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function index()
    {
        return view(
            'admin.products.index',
            ['products' => Product::all()->sortDesc()]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        if (!empty($validated['promotion']['quantity']) &&
            $validated['promotion']['quantity'] !== 0 &&
            !empty($validated['promotion']['total'])
        ) {
            $product->promotion()->create($validated['promotion']);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param EditRequest $request
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function edit(EditRequest $request, string $id)
    {
        $product = Product::find($id);

        return view(
            'admin.products.edit',
            [
                'product' => Product::find($id),
                'promotion' => $product->promotion,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
        ]);

        if (!empty($validated['promotion']['quantity']) &&
            $validated['promotion']['quantity'] !== 0 &&
            !empty($validated['promotion']['total'])
        ) {
            if (!empty($validated['promotion_id'])) {
                $promotion = Promotion::find($validated['promotion_id']);
                if ($promotion) {
                    $promotion->update($validated['promotion']);
                }
            } else {
                $product->promotion()->create($validated['promotion']);
            }
        }

        return redirect()
            ->route('products.index')->with('success', 'Product updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
