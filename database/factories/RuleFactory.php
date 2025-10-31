<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rules>
 */
class RuleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['free', 'premiun']),
            'downloads' => $this->faker->numberBetween(1, 5000),
            'rating' => $this->faker->numberBetween(1, 3.5, 5),
            'description' => $this->faker->paragraph(),
            'category_id' => Category::factory(),
            'status' => 'active',
            'metadata' => [
                'version' => ['1.1'],
            ],
        ];
    }
}
