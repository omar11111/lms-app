<?php

// Contracts/CourseCreatorInterface.php — Product Interface

namespace App\Factories\CourseFactory\Contracts;

use App\Models\Course;

interface CourseCreatorInterface
{
    public function create(array $data): Course;
}
