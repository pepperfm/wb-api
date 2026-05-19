<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
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
            'date' => fake()->dateTimeBetween('-1 month'),
            'barcode' => fake()->unique()->numerify('########'),
            'total_price' => fake()->randomFloat(2, 100, 10000),
            'g_number' => fake()->unique()->numerify('order-########'),
        ];
    }
}
