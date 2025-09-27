<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined keys and values
        $tags = [
            'industry' => ['fintech', 'edtech', 'climate', 'consumer'],
            'business model' => ['b2b', 'b2c', 'marketplace', 'saas', 'subscription'],
            'customer segment' => ['students', 'SMBs', 'enterprises', 'freelancers'],
            'stage' => ['idea', 'prototype', 'mvp', 'scaling'],
            'revenue model' => ['ads', 'subscription', 'free' , 'transaction fees'],
            "" => [ "ai", "social", "climate", "web3", "marketplace", "bootstrapped", "scalable", "community" ]
        ];

        // Pick a random key and value
        $key = $this->faker->randomElement(array_keys($tags));
        $value = $this->faker->randomElement($tags[$key]);

        return [
            'key' => $key,
            'value' => $value,
        ];
    }
}
