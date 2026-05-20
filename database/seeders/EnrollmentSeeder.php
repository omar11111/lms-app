<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $courses = Course::all();

        // كل user بيتسجل في 2-5 courses عشوائية
        $users->each(function ($user) use ($courses) {
            $courses->random(rand(2, 5))->each(function ($course) use ($user) {
                Enrollment::firstOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ]);
            });
        });
    }
}
