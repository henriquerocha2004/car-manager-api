<?php

namespace App\Dto;

abstract class BaseDto
{
    public function toArray(): array
    {
        return collect(get_object_vars($this))
            ->mapWithKeys(fn ($value, $key) => [Str::snake($key) => $value])
            ->toArray();
    }
}
