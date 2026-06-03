<?php

namespace App\Providers;

use App\Factories\CourseFactory\CourseResolver;
use App\Factories\CourseFactory\Creators\CohortCourseCreator;
use App\Factories\CourseFactory\Creators\LiveCourseCreator;
use App\Factories\CourseFactory\Creators\SelfPacedCourseCreator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(CourseResolver::class, fn () => new CourseResolver([
            new SelfPacedCourseCreator,
            new CohortCourseCreator,
            new LiveCourseCreator,
        ]));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
