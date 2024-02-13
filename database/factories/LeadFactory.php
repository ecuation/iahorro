<?php

namespace Database\Factories;

use App\Enums\MortgagePurposes;
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
            'mortgage_request_amount' => $this->faker->randomNumber(),
            'purpose_mortgage' => $this->faker->randomElement(MortgagePurposes::options()),
            'score' => rand(0, 100)
        ];
    }
}
