<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAttribute
{
    /** @phpstan-ignore-next-line */
    public function apgId(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => 'APG-' . formatedId($attributes['id']),
        );
    }
}
