<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promotion extends Model
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
    ];
}
