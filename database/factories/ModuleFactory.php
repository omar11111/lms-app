<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ModuleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $modules = [
            'Backend Development',
            'Frontend Development',
            'Mobile Development',
            'DevOps & Cloud',
            'Data Science',
            'Cyber Security',
            'UI/UX Design',
            'Database Administration',
        ];

        return [
            'title'       => fake()->unique()->randomElement($modules),
            'description' => fake()->boolean(80) ? fake()->paragraph(3) : null,
        ];
    }
}
