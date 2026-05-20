<?php

namespace Database\Factories;

use App\Enums\CourseStatus;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'image' => fake()->boolean(70) ? 'https://picsum.photos/640/480?random='.fake()->numberBetween(1, 100) : null,
            'video' => fake()->boolean(60) ? 'https://www.youtube.com/watch?v='.fake()->lexify('???????????') : null,
            'price' => fake()->randomElement([0, 9.99, 19.99, 49.99, 99.99, 149.99, 199.99]),
            'module_id' => Module::factory(),
            'total_hours' => fake()->randomNumber(5),
            'status' => CourseStatus::Draft,
        ];
    }
}
