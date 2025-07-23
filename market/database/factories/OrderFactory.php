<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total' => $this->faker->numberBetween(1, 1000),
            'sku_string' => $this->faker->randomElement(['ABDAA', 'AAABBBCCC', 'ABCCDAA', 'CDCABDAA']),
            'status' => $this->faker->randomElement(array_keys(Order::STATUSES)),
        ];
    }
}
