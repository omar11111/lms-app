<?php

namespace App\Http\Controllers;

use App\Exceptions\CourseCreationException;
use App\Factories\CourseFactory\CourseResolver;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseApiResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function __construct(
        private CourseResolver $resolver,
    ) {}

    public function store(StoreCourseRequest $request): JsonResponse
    {
        try {
            $course = $this->resolver
                ->resolve($request->input('type'))
                ->create($request->except(['_token', '_method']));

            return response()->json([
                'success' => true,
                'data' => new CourseApiResource($course)
            ], 201);
        } catch (CourseCreationException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function index()
    {
        $courses = Course::published()->withRelations()->paginate();
        return CourseApiResource::collection($courses);
    }

    public function show(Course $course): CourseApiResource
    {
        $course->loadMissing([
            'module',
            'category',
            'instructor',
        ]);

        return new CourseApiResource($course);
    }

    public function update(Course $course,) {}
}
