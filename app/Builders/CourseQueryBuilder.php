<?php

namespace App\Builders;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Builder;

class CourseQueryBuilder extends Builder
{
    public function published(): static
    {
        return $this->where('status', CourseStatus::Published);
    }

    public function featured(): static
    {
        return $this->where('status', CourseStatus::Featured);
    }

    public function byInstructor(int $instructorId): static
    {
        return $this->where('instructor_id', $instructorId);
    }

    public function byCategoryTitle(string $title): static
    {
        return $this->whereRelation('category', 'title', '=', $title);
    }

    public function withRelations(): static
    {
        return $this->with(['module', 'lessons', 'enrollments', 'students', 'instructor', 'category', 'schedule']);
    }
}
