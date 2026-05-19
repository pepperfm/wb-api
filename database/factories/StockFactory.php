<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'last_change_date' => fake()->dateTimeBetween('-1 month'),
            'barcode' => fake()->unique()->numerify('########'),
            'quantity' => fake()->numberBetween(0, 1000),
        ];
    }
}
