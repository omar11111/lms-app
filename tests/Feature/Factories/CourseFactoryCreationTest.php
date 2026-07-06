<?php

namespace Tests\Feature\Factories;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Exceptions\CourseCreationException;
use App\Factories\CourseFactory\Creators\CohortCourseCreator;
use App\Factories\CourseFactory\Creators\LiveCourseCreator;
use App\Factories\CourseFactory\Creators\SelfPacedCourseCreator;
use App\Models\Module;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseFactoryCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_self_paced_creator_creates_a_published_course(): void
    {
        $module = Module::factory()->create();

        $course = (new SelfPacedCourseCreator)->create([
            'title' => 'Laravel from Zero',
            'description' => 'A complete self-paced course',
            'price' => 49.99,
            'total_hours' => 12,
            'module_id' => $module->id,
        ]);

        $this->assertSame(CourseType::SelfPaced, $course->type);
        $this->assertSame(CourseStatus::Published, $course->status);
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'type' => CourseType::SelfPaced->value,
        ]);
    }

    public function test_self_paced_creator_throws_on_invalid_data(): void
    {
        $this->expectException(CourseCreationException::class);

        (new SelfPacedCourseCreator)->create([
            'title' => '', // required
        ]);
    }

    public function test_cohort_creator_creates_a_scheduled_course_with_a_schedule(): void
    {
        $module = Module::factory()->create();

        $course = (new CohortCourseCreator)->create([
            'title' => 'Backend Bootcamp',
            'description' => 'Cohort based backend training',
            'price' => 199.99,
            'total_hours' => 40,
            'module_id' => $module->id,
            'start_date' => now()->addWeek()->toDateTimeString(),
            'end_date' => now()->addWeeks(6)->toDateTimeString(),
            'max_students' => 25,
        ]);

        $this->assertSame(CourseType::Cohort, $course->type);
        $this->assertSame(CourseStatus::Scheduled, $course->status);
        $this->assertNotNull($course->schedule);
        $this->assertSame(25, $course->schedule->max_students);
        $this->assertDatabaseHas('course_schedules', [
            'course_id' => $course->id,
            'max_students' => 25,
        ]);
    }

    public function test_cohort_creator_throws_when_end_date_is_before_start_date(): void
    {
        $module = Module::factory()->create();

        $this->expectException(CourseCreationException::class);

        (new CohortCourseCreator)->create([
            'title' => 'Invalid Cohort',
            'description' => 'Should fail',
            'price' => 99,
            'total_hours' => 10,
            'module_id' => $module->id,
            'start_date' => now()->addWeek()->toDateTimeString(),
            'end_date' => now()->toDateTimeString(), // قبل start_date
            'max_students' => 20,
        ]);
    }

    public function test_live_creator_creates_a_scheduled_course_with_full_schedule(): void
    {
        $module = Module::factory()->create();

        $course = (new LiveCourseCreator)->create([
            'title' => 'Live System Design',
            'description' => 'Weekly live sessions',
            'price' => 299,
            'total_hours' => 20,
            'module_id' => $module->id,
            'start_date' => now()->addDays(3)->toDateTimeString(),
            'end_date' => now()->addWeeks(4)->toDateTimeString(),
            'max_students' => 15,
            'timezone' => 'Africa/Cairo',
            'meeting_url' => 'https://zoom.us/j/123456789',
            'cover_image' => 'covers/live.png',
        ]);

        $this->assertSame(CourseType::Live, $course->type);
        $this->assertSame(CourseStatus::Scheduled, $course->status);
        $this->assertSame('Africa/Cairo', $course->schedule->timezone);
        $this->assertDatabaseHas('course_schedules', [
            'course_id' => $course->id,
            'meeting_url' => 'https://zoom.us/j/123456789',
        ]);
    }

    public function test_live_creator_throws_when_required_live_only_fields_are_missing(): void
    {
        $module = Module::factory()->create();

        $this->expectException(CourseCreationException::class);

        (new LiveCourseCreator)->create([
            'title' => 'Missing meeting url',
            'description' => 'Should fail validation',
            'price' => 99,
            'total_hours' => 10,
            'module_id' => $module->id,
            'start_date' => now()->addWeek()->toDateTimeString(),
            'end_date' => now()->addWeeks(2)->toDateTimeString(),
            'max_students' => 10,
            'timezone' => 'Africa/Cairo',
            // meeting_url و cover_image ناقصين عن قصد
        ]);
    }
}
