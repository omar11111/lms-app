<?php
namespace Tests\Feature\Course;
use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use App\Enums\CourseStatus;
use App\Enums\CourseType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class CourseTestCase extends TestCase {
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
}
