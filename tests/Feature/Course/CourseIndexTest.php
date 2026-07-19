<?php

namespace Tests\Feature\Course;

use App\Enums\CourseStatus;
use App\Models\Course;

class CourseIndexTest extends CourseTestCase
{
    public function test_can_get_published_courses()
    {
        Course::factory()
            ->count(3)
            ->create([
                'status' => CourseStatus::Published,
            ]);

        Course::factory()
            ->count(2)
            ->create([
                'status' => CourseStatus::Featured,
            ]);
        $response = $this->getJson('api/courses');
        $response->assertOk();
        $response->assertJsonCount(3, 'data');
        $data = $response->json('data');
        foreach ($data as $course) {
            $this->assertEquals(
                CourseStatus::Published->value,
                $course['status']
            );
        }
    }

    public function test_returns_empty_data_when_no_published_courses_exist()
    {
        $response = $this->json('get', 'api/courses');
        $response->assertOk();
        $response->assertJsonStructure([
            'data',
            'links',
            'meta',
        ]);
        $response->assertJsonCount(0, 'data');
    }

    public function test_get_courses_with_pagination()
    {
        $neededData = $this->validPayload();
        Course::factory()
            ->count(20)
            ->create([
                'status' => CourseStatus::Published,
                'module_id' => $neededData['module_id'],
                'category_id' => $neededData['category_id'],
                'instructor_id' => $neededData['instructor_id'],
            ]);
        $response = $this->getJson('api/courses');
        $response->assertOk();

        $response->assertJsonStructure([
            'data',
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'last_page', 'per_page', 'total']
        ]);

        $response->assertJsonPath('meta.current_page', 1);
        $response->assertJsonPath('meta.per_page', 15);
        $response->assertJsonPath('meta.total', 20);
        $response->assertJsonPath('meta.last_page', 2);

        $response->assertJsonCount(15, 'data');
    }
}
