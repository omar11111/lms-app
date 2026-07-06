<?php

namespace Tests\Unit\Factories;

use App\Exceptions\CourseCreationException;
use App\Factories\CourseFactory\Contracts\CourseCreatorInterface;
use App\Factories\CourseFactory\CourseFactory;
use App\Factories\CourseFactory\CourseResolver;
use App\Models\Course;
use PHPUnit\Framework\TestCase;

class CourseResolverTest extends TestCase
{
    /**
     * بنعمل stub بسيط بيطبق CourseFactory عشان نختبر منطق الـ resolve()
     * لوحده، من غير ما نتعامل مع الـ Products الحقيقية أو الـ DB.
     */
    private function fakeCreator(string $type): CourseFactory
    {
        return new class($type) extends CourseFactory
        {
            public function __construct(private string $type) {}

            public function supports(string $type): bool
            {
                return $type === $this->type;
            }

            protected function createCreator(): CourseCreatorInterface
            {
                return new class implements CourseCreatorInterface
                {
                    public function create(array $data): Course
                    {
                        return new Course;
                    }
                };
            }
        };
    }

    public function test_it_resolves_the_matching_creator(): void
    {
        $cohort = $this->fakeCreator('cohort');
        $live = $this->fakeCreator('live');

        $resolver = new CourseResolver([$cohort, $live]);

        $this->assertSame($live, $resolver->resolve('live'));
    }

    public function test_it_returns_the_first_matching_creator_when_multiple_match(): void
    {
        $first = $this->fakeCreator('live');
        $second = $this->fakeCreator('live');

        $resolver = new CourseResolver([$first, $second]);

        $this->assertSame($first, $resolver->resolve('live'));
    }

    public function test_it_throws_when_no_creator_supports_the_type(): void
    {
        $resolver = new CourseResolver([$this->fakeCreator('cohort')]);

        $this->expectException(CourseCreationException::class);
        $this->expectExceptionMessage('Unknown course type: workshop');

        $resolver->resolve('workshop');
    }

    public function test_it_throws_when_creators_list_is_empty(): void
    {
        $resolver = new CourseResolver([]);

        $this->expectException(CourseCreationException::class);

        $resolver->resolve('cohort');
    }
}
