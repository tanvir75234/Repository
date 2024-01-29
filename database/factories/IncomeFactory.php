<?php

namespace Database\Factories;
use Illuminate\Support\Str;
use App\Models\Income;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Income>
 */
class IncomeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array{
        return [
            'incate_id' =>fake()->numberBetween(1,10),
            'income_title' => fake()->name(50),
            'income_amount' =>fake()->numberBetween(100,100000),
            'income_date' => fake()->dateTimeThisMonth()->format('Y-m-d'),
        ];
    }
}
