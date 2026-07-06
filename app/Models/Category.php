<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * @property Collection<int, Course> $courses
 */
#[Fillable(['title', 'slug', 'description'])]
class Category extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            $category->slug ??= Str::slug($category->title);
        });
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
