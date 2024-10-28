<?php

namespace TomatoPHP\FilamentTypes\Services;

use Illuminate\Support\Collection;

class FilamentTypesServices
{
    protected array $types = [];

    public function register($types): void
    {
        if (is_array($types)) {
            foreach ($types as $type) {
                $this->register($type);
            }
        } else {
            $this->types[] = $types;
        }
    }

    public function get(): Collection
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return collect($this->types)
            ->merge(filament('filament-types')->getTypes())
            ->groupBy(fn($typeFor) => $typeFor->for) // Group by `for` attribute
            ->map(function ($group) use ($model) {
                return $group
                    ->groupBy(fn($typeFor) => $typeFor->for) // Group by `label` within each `for` group
                    ->map(function ($labelGroup) use ($model) {
                        $mergedTypes = $labelGroup->flatMap(fn($typeFor) => $typeFor->types)
                            ->map(function ($getType) use ($labelGroup, $model) {
                                $getType->label = ! $getType->label ? str($getType->type)->title()->toString() : $getType->label;

                                if (is_array($getType->types) && count($getType->types)) {
                                    foreach ($getType->types as $typeItem) {
                                        $checkExists = $model::query()
                                            ->where('key', $typeItem->key)
                                            ->where('type', $getType->type)
                                            ->where('for', $labelGroup->first()->for)
                                            ->first();

                                        if (! $checkExists) {
                                            $model::query()->create([
                                                'key' => $typeItem->key,
                                                'type' => $getType->type,
                                                'icon' => $typeItem->icon,
                                                'color' => $typeItem->color,
                                                'for' => $labelGroup->first()->for,
                                                'name' => $typeItem->name,
                                            ]);
                                        }
                                    }
                                }

                                return $getType;
                            })
                            ->unique('type') // Ensure unique by `type`
                            ->values(); // Reindex after unique filter

                        $firstItem = $labelGroup->first();
                        $firstItem->types = $mergedTypes->toArray();

                        return $firstItem;
                    })
                    ->values();
            })
            ->flatten();
    }
}
