<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * Columns
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price',
    ];

    /**
     * Relationship with promotion
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function promotion() : HasOne
    {
        return $this->hasOne(Promotion::class);
    }

    /**
     * Many-to-many relationship with orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders() : BelongsToMany
    {
        return $this
            ->belongsToMany(Order::class)
            ->withPivot([
                'quantity',
                'final_price',
            ])
            ->withTimestamps();
    }
}
