<?php

namespace App\Casts;

use App\ValueObjects\Price;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PriceCast implements CastsAttributes
{
    /*
     *
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
    */
    public function get(Model $model, string $key, mixed $value, array $attributes): Price
    {
        return new Price($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): float
    {
        if ($value instanceof Price) {
            return $value->amount;
        }

        return (float) $value;
    }
}
