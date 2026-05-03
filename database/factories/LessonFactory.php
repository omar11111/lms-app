<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    // LessonFactory.php
    public function definition(): array
    {
        $prefixes = ['Introduction to', 'Deep Dive into', 'Understanding', 'Mastering', 'Getting Started with'];

        $topics = [
            'Routing',
            'Middleware',
            'Authentication',
            'APIs',
            'Databases',
            'Caching',
            'Queues',
            'Testing',
            'Deployment',
            'Security'
        ];

        return [
            'title'       => fake()->randomElement($prefixes) . ' ' . fake()->randomElement($topics),
            'description' => fake()->boolean(80) ? fake()->paragraph(2) : null,
            'video'       => fake()->boolean(85) ? 'https://www.youtube.com/watch?v=' . fake()->lexify('???????????') : null,
            'course_id'   => Course::factory(),
            'duration'    => fake()->randomNumber()
        ];
    }
}
