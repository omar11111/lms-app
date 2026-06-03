<?php

namespace App\Factories\CourseFactory;

use App\Exceptions\CourseCreationException;

class CourseResolver
{
    /** @param CourseFactory[] $creators */
    public function __construct(
        private array $creators,
    ) {}

    public function resolve(string $type): CourseFactory
    {
        foreach ($this->creators as $creator) {
            if ($creator->supports($type)) {
                return $creator;
            }
        }

        throw new CourseCreationException("Unknown course type: {$type}");
    }
}
