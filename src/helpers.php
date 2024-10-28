<?php

use Illuminate\Database\Eloquent\Model;

if (! function_exists('type_of')) {
    function type_of(string $key, string $for, string $type): ?Model
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return $model::query()
            ->where('key', $key)
            ->where('for', $for)
            ->where('type', $type)
            ->first();
    }
}
