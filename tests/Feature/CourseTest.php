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
    public function test_can_create_course()
    {
        $module     = Module::factory()->create();
        $category   = Category::factory()->create();
        $instructor = User::factory()->create();
        $response   = $this->postJson(
            'api/courses',
            [
                'title' => 'name',
                'description' => 'description',
                'image' => fake()->boolean(70) ? 'https://picsum.photos/640/480?random=' . fake()->numberBetween(1, 100) : null,
                'video' => fake()->boolean(60) ? 'https://www.youtube.com/watch?v=' . fake()->lexify('???????????') : null,
                'price' => fake()->randomElement([0, 9.99, 19.99, 49.99, 99.99, 149.99, 199.99]),
                'module_id' => $module->id,
                'total_hours' => 5,
                'instructor_id' => $instructor->id,
                'category_id' => $category->id,
                'type'  => CourseType::Cohort->value,
                'status' => CourseStatus::Published->value
            ]
        );

        $response->assertCreated();

        $this->assertDatabaseHas('courses', [
            'title' => 'name',
            'module_id' => $module->id,
            'category_id' => $category->id,
        ]);

        $response->assertJsonPath('success', true);
    }

    public function test_validation_fails_when_title_is_missing()
    {
        $module = Module::factory()->create();
        $category = Category::factory()->create();
        $instructor = User::factory()->create();

        $response = $this->postJson('/api/courses', [
            // title محذوف
            'description' => 'description',
            'module_id' => $module->id,
            'category_id' => $category->id,
            'instructor_id' => $instructor->id,
            'type' => CourseType::Cohort->value,
            'status' => CourseStatus::Published->value,
        ]);

        $response->assertUnprocessable();

        $response->assertJsonValidationErrors([
            'title'
        ]);
    }

    public function test_validation_fails_when_module_does_not_exist()
{
    $category = Category::factory()->create();
    $instructor = User::factory()->create();

    $response = $this->postJson('/api/courses', [
        'title' => 'Laravel',
        'module_id' => 999999,
        'category_id' => $category->id,
        'instructor_id' => $instructor->id,
        'type' => CourseType::Cohort->value,
        'status' => CourseStatus::Published->value,
    ]);

    $response->assertUnprocessable();

    $response->assertJsonValidationErrors([
        'module_id'
    ]);
}
}
