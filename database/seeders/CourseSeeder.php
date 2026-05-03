<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // كل module فيها 3-5 courses
        Module::all()->each(function ($module) {
            Course::factory(rand(3, 5))->create([
                'module_id' => $module->id,
            ]);
        });
    }
}
