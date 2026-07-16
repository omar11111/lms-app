<?php

namespace Tests\Feature;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use Database\Factories\ModuleFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;
    public function validPayload($overrides = [])
    {
        $module     = Module::factory()->create();
        $category   = Category::factory()->create();
        $instructor = User::factory()->create();
        $basicCourseData = [
            'title' => 'name',
            'description' => 'description',
            'image' => fake()->boolean(70) ? 'https://picsum.photos/640/480?random=' . fake()->numberBetween(1, 100) : null,
            'video' => fake()->boolean(60) ? 'https://www.youtube.com/watch?v=' . fake()->lexify('???????????') : null,
            'price' => fake()->randomElement([0, 9.99, 19.99, 49.99, 99.99, 149.99, 199.99]),
            'module_id' => $module->id,
            'total_hours' => 5,
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'type'   => CourseType::SelfPaced->value,
            'status' => CourseStatus::Published->value
        ];
        $finalData = array_merge($basicCourseData, $overrides);

        return $finalData;
    }
    public function test_can_create_course()
    {
        $neededDataToTest = $this->validPayload([]);
        $response   = $this->postJson(
            'api/courses',
            $neededDataToTest
        );

        $response->assertCreated();

        $this->assertDatabaseHas('courses', [
            'title' => 'name',
            'module_id' => $neededDataToTest['module_id'],
            'category_id' => $neededDataToTest['category_id'],
        ]);

        $response->assertJsonPath('success', true);
    }

    public function test_validation_fails_when_title_is_missing()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['title' => '']));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function test_validation_fails_when_description_is_missing()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['description' => '']));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'description'
        ]);
    }

    public function test_validation_fails_when_price_is_negative()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['price' => -1]));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'price'
        ]);
    }


    public function test_validation_fails_when_total_hours_is_negative()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['total_hours' => -1]));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'total_hours'
        ]);
    }

    public function test_validation_fails_when_module_does_not_exist()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['module_id' => 777777777]));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'module_id'
        ]);
    }

    public function test_validation_fails_when_category_does_not_exist()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['category_id' => 7777777]));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'category_id'
        ]);
    }

    public function test_validation_fails_when_instructor_does_not_exist()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['instructor_id' => 77777777]));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'instructor_id'
        ]);
    }


    public function test_validation_fails_when_invalid_type_is_given()
    {
        $response = $this->postJson('/api/courses', $this->validPayload(['type' => 'invalid']));

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'type',
        ]);
    }

    public function test_create_cohort_course()
    {
        $neededDataToTest = $this->validPayload([
            'type' => CourseType::Cohort->value,
            'start_date' => '20-07-2026',
            'end_date' => '20-08-2026',
            'max_students' => 50,
        ]);

        $response = $this->postJson('/api/courses', $neededDataToTest);

        $response->assertCreated();

        $this->assertDatabaseHas('courses', [
            'title' => 'name',
            'module_id' => $neededDataToTest['module_id'],
            'category_id' => $neededDataToTest['category_id'],
            'type' => CourseType::Cohort->value
        ]);

        $response->assertJsonPath('success', true);
    }

    public function test_create_live_course()
    {
        $neededDataToTest = $this->validPayload([
            'type' => CourseType::Live->value,
            'start_date' => '20-07-2026',
            'end_date' => '20-08-2026',
            'max_students' => 50,
            'meeting_url' => 'https://meet.google.com/abc-defg-hij',
            'cover_image' => 'course-cover.jpg',
            'timezone' => 'Africa/Cairo',
        ]);

        $response = $this->postJson('/api/courses', $neededDataToTest);

        $response->assertCreated();

        $this->assertDatabaseHas('courses', [
            'title' => 'name',
            'module_id' => $neededDataToTest['module_id'],
            'category_id' => $neededDataToTest['category_id'],
            'type' => CourseType::Live->value
        ]);

        $response->assertJsonPath('success', true);
    }
}
