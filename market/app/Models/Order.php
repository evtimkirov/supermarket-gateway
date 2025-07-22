<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'quantity',
        'total',
        'status',
    ];

    /**
     * Many-to-many relationship with products
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products() : BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot([
                'quantity',
                'final_price',
            ])
            ->withTimestamps();
    }

    /**
     * Create an order with all the selected products
     *
     * @param $totalPricePerItem
     * @param $product
     * @param $order
     * @param $quantity
     * @return mixed
     */
    public static function createOrderWithProducts($totalPricePerItem, $product, $order, $quantity)
    {
        $order
            ->products()
            ->attach(
                $product->id,
                [
                    'quantity' => $quantity,
                    'final_price' => $totalPricePerItem,
                ]
            );

        return $totalPricePerItem;
    }
}
