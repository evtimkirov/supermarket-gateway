<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Product::all() as $product) {
            if ($product->name === 'A') {
                $product->promotion()->create(['quantity' => 3, 'total' => 130]);
            }
            if ($product->name === 'B') {
                $product->promotion()->create(['quantity' => 2, 'total' => 45]);
            }
        }
    }
}
