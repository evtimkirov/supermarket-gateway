<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'A',
                'price' => 50,
            ],
            [
                'name' => 'B',
                'price' => 30,
            ],
            [
                'name' => 'C',
                'price' => 20,
            ],
            [
                'name' => 'D',
                'price' => 10,
            ],
        ]);
    }
}
