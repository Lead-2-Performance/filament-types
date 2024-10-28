<?php

namespace TomatoPHP\FilamentTypes\Filament\Resources\TypeResource\Form\Components;

use Filament\Forms;
use Filament\Forms\Components\Field;

class TypeParent extends Component
{
    public static function make(): Field
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return Forms\Components\Select::make('parent_id')
            ->label(trans('filament-types::messages.form.parent_id'))
            ->columnSpan(2)
            ->options($model::whereNull('parent_id')
                ->get()
                ->pluck('name', 'id')
                ->toArray())
            ->searchable()
            ->live();
    }
}
