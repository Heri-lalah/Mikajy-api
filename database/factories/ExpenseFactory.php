<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(1),
            'amount' => rand(1,20) * 100,
            'currency' => 'Ariary',
            'remark' => fake()->paragraph(1),
            'user_id' => User::factory()->create()
        ];
    }
}
