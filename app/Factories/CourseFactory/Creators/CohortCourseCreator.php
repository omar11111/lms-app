<?php

namespace App\Factories\CourseFactory\Creators;

use App\Enums\CourseType;
use App\Factories\CourseFactory\Contracts\CourseCreatorInterface;
use App\Factories\CourseFactory\CourseFactory;
use App\Factories\CourseFactory\Products\CohortProduct;

class CohortCourseCreator extends CourseFactory
{
    public function supports(string $type): bool
    {
        return $type === CourseType::Cohort->value;
    }

    protected function createCreator(): CourseCreatorInterface
    {
        return new CohortProduct;
    }
}
