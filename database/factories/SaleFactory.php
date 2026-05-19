<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sale>
 */
class SaleFactory extends Factory
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
            'sale_id' => fake()->unique()->numerify('S########'),
            'barcode' => fake()->unique()->numerify('########'),
            'total_price' => fake()->randomFloat(2, 100, 10000),
        ];
    }
}
