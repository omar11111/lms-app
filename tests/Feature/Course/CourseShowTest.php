<?php

namespace Tests\Feature\Course;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseSchedule;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseShowTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_existing_course(): void
    {
        // Arrange
        $course = Course::factory()->create();

        // Act
        $response = $this->getJson("/api/courses/{$course->id}");

        // Assert
        $response->assertOk();
        $response->assertJsonPath('data.id', $course->id);
        $response->assertJsonPath('data.title', $course->title);
        $response->assertJsonPath('data.description', $course->description);
    }

    public function test_not_existing_course()
    {
        $response = $this->getJson('api/courses/99999999');
        $response->assertNotFound();
    }

    public function test_returns_course_with_relations()
    {
        //arrange
        $course = Course::factory()->create();
        // Act
        $response = $this->getJson("/api/courses/{$course->id}");

        // Assert
        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'module',
                'category',
                'instructor'
            ]
        ]);
        $response->assertJsonPath('data.id', $course->id);
        $response->assertJsonPath('data.title', $course->title);
        $response->assertJsonPath('data.description', $course->description);
        $response->assertJsonPath('data.module.id', $course->module->id);
        $response->assertJsonPath('data.category.id', $course->category->id);
        $response->assertJsonPath('data.instructor.id', $course->instructor->id);
    }

    public function test_returns_course_schedule_when_exists(): void
    {
        // Arrange
        $course = Course::factory()->create();

        $schedule = CourseSchedule::factory()->create([
            'course_id' => $course->id,
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-30',
            'max_students' => 50,
        ]);

        // Act
        $response = $this->getJson("/api/courses/{$course->id}");

        // Assert
        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'schedule' => [
                    'id',
                    'start_date',
                    'end_date',
                    'max_students',
                ],
            ],
        ]);

        $response->assertJsonPath(
            'data.schedule.id',
            $schedule->id
        );

        $response->assertJsonPath(
            'data.schedule.start_date',
            $schedule->start_date->toDateString()
        );

        $response->assertJsonPath(
            'data.schedule.end_date',
            $schedule->end_date->toDateString()
        );

        $response->assertJsonPath(
            'data.schedule.max_students',
            $schedule->max_students
        );
    }
}
