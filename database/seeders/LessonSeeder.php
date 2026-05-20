<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // كل course فيها 5-10 lessons
        Course::all()->each(function ($course) {
            Lesson::factory(rand(5, 10))->create([
                'course_id' => $course->id,
            ]);
        });
    }
}
