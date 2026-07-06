<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'title' => ucfirst($title),
            'slug' => Str::slug($title),
            'description' => fake()->boolean(70) ? fake()->sentence(10) : null,
        ];
    }
}
