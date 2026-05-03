<?php

namespace App\Casts;

use App\ValueObjects\LessonDuration;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class LessonDurationCast implements CastsAttributes
{
    /*
     *
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
    */
    public function get(Model $model, string $key, mixed $value, array $attributes): LessonDuration
    {
        return new LessonDuration($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): float
    {
        if ($value instanceof LessonDuration) {
            return $value->seconds;
        }

        return (float) $value;
    }
}
