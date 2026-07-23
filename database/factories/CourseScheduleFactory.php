<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 month');
        $endDate = (clone $startDate)->modify('+30 days');

        return [
            'course_id' => Course::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_students' => fake()->numberBetween(10, 100),
            'timezone' => 'Africa/Cairo',
            'meeting_url' => fake()->url(),
            'cover_image' => fake()->imageUrl(640, 480, 'education'),
        ];
    }
}
