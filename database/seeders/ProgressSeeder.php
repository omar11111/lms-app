<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Database\Seeder;

class ProgressSeeder extends Seeder
{
    public function run(): void
    {
        // لكل enrollment، نعمل progress على lessons الـ course
        Enrollment::with('course.lessons')->each(function ($enrollment) {

            $lessons = $enrollment->course->lessons;

            // مش كل الـ lessons — بيكمل 40%-100% من الكورس
            $completedCount = (int) ceil($lessons->count() * fake()->randomFloat(1, 0.4, 1.0));

            $lessons->take($completedCount)->each(function ($lesson) use ($enrollment) {
                $score = fake()->numberBetween(0, 100);

                Progress::firstOrCreate(
                    [
                        'user_id'   => $enrollment->user_id,
                        'lesson_id' => $lesson->id,
                    ],
                    [
                        'score'        => $score,
                        'is_completed' => $score >= 50,
                    ]
                );
            });
        });
    }
}
