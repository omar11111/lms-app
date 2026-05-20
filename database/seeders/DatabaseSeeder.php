<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class,
            CourseSeeder::class,
            LessonSeeder::class,
            UserSeeder::class,
            EnrollmentSeeder::class,
            ProgressSeeder::class,
        ]);
    }
}
