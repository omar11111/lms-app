<?php

namespace App\Factories\CourseFactory\Products;

use App\Enums\CourseStatus;
use App\Enums\CourseType;
use App\Exceptions\CourseCreationException;
use App\Factories\CourseFactory\Contracts\CourseCreatorInterface;
use App\Models\Course;
use Illuminate\Support\Facades\Validator;

class CohortProduct implements CourseCreatorInterface
{
    public function create(array $data): Course
    {
        $validated = $this->validate($data);

        return Course::create([
            ...$validated,
            'type' => CourseType::Cohort,
            'status' => CourseStatus::Scheduled,
        ]);
    }

    private function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'total_hours' => 'required|integer|min:1',
            'module_id' => 'required|integer|exists:modules,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'max_students' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            throw new CourseCreationException(
                'خطأ في بيانات Cohort: '.$validator->errors()->first()
            );
        }

        return $validator->validated();
    }
}
