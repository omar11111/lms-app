<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgressFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $score = fake()->numberBetween(0, 100);

        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'score' => $score,
            'is_completed' => $score >= 50,
        ];
    }
}
