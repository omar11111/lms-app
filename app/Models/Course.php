<?php

namespace App\Models;

use App\Builders\CourseQueryBuilder;
use App\Casts\PriceCast;
use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection<int, Lesson> $lessons
 * @property Collection<int, Enrollment> $enrollments
 * @property Collection<int, User> $students
 * @property Module $module
 */
#[Fillable([
    'title',
    'description',
    'image',
    'video',
    'price',
    'module_id',
    'total_hours',
])]
class Course extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => PriceCast::class,
        'status' => CourseStatus::class,
    ];

    public function newEloquentBuilder($query): CourseQueryBuilder
    {
        return new CourseQueryBuilder($query);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments')->withTimestamps();
    }
}
