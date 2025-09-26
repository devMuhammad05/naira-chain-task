<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'invoice_number' => $this->faker->unique()->numerify('INV-####'),
            'description' => $this->faker->sentence(),
            'billing_name' => $this->faker->name(),
            'billing_email' => $this->faker->unique()->safeEmail(),
            'billing_address' => $this->faker->address(),
            'total_amount' => $this->faker->numberBetween(100, 5000),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'issue_date' => now()->format('Y-m-d'),
            'status' => $this->faker->randomElement(['Paid', 'Overdue']),
        ];
    }
}
