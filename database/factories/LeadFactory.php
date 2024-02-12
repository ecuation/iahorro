<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->email,
            'mortgage_request_amount' => $this->faker->randomNumber(),
            'purpose_mortgage' => $this->faker->randomElement([
                'primera-vivienda', 'segunda-vivienda'
            ]),
            'score' => rand(0, 100)
        ];
    }
}
