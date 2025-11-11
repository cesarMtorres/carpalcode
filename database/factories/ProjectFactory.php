<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'owner_id' => $this->faker->numberBetween(1, 10),
            'repo' => $this->faker->url(),
            'path' => $this->faker->url(),
            'language' => 'php',
            'rules' => [
                'name' => 'collective_to_spatie',
            ],
        ];
    }
}
