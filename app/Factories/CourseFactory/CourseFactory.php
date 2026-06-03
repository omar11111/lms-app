<?php

namespace App\Factories\CourseFactory;

use App\Factories\CourseFactory\Contracts\CourseCreatorInterface;
use App\Models\Course;

abstract class CourseFactory
{
    abstract protected function createCreator(): CourseCreatorInterface;

    abstract public function supports(string $type): bool;

    public function create(array $data): Course
    {
        $creator = $this->createCreator();

        return $creator->create($data);
    }
}
