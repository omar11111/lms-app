<?php

namespace App\Models;

use App\Casts\LessonDurationCast;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'description',
    'video',
    'course_id',
    'duration',
])]
class Lesson extends Model
{
    use HasFactory;

    public $casts = [
        'duration' => LessonDurationCast::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(Progress::class);
    }
}
