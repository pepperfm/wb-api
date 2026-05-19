<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Income;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'income_id' => fake()->numberBetween(1, 1_000_000),
            'date' => fake()->date(),
            'last_change_date' => fake()->dateTimeBetween('-1 month'),
            'quantity' => fake()->numberBetween(1, 1000),
            'total_price' => fake()->randomFloat(2, 100, 100000),
        ];
    }
}
