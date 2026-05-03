<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users   = User::all();
        $courses = Course::all();

        // كل user بيتسجل في 2-5 courses عشوائية
        $users->each(function ($user) use ($courses) {
            $courses->random(rand(2, 5))->each(function ($course) use ($user) {
                Enrollment::firstOrCreate([
                    'user_id'   => $user->id,
                    'course_id' => $course->id,
                ]);
            });
        });
    }
}
