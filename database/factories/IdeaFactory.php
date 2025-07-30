<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            "title" => fake()->text(20),
            "description" => fake()->paragraph(5),
            "short_description" => fake()->paragraph(1),
            "type" => fake()->randomElement(['Saas/app', 'Service', 'Product/tech', 'Saas/Social','Web app']),
            "rating" => fake()->numberBetween(0, 100)
        ];
    }
}
