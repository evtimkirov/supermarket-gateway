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
            ]);
    }
}
