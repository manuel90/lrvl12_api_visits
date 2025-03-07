<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Visit;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "start_date" => fake()->date('Y-m-d H:i:s'),
            "end_date" => fake()->date('Y-m-d H:i:s'),
            "description" => fake()->sentence(),
            "status" => fake()->randomElement(Visit::STATUS_ALLOWS),
        ];
    }
}
