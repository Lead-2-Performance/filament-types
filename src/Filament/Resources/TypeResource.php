<?php

namespace TomatoPHP\FilamentTypes\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use TomatoPHP\FilamentTypes\Filament\Resources\TypeResource\Form\TypeForm;
use TomatoPHP\FilamentTypes\Filament\Resources\TypeResource\Table\TypeTable;


class TypeResource extends Resource
{
    use Translatable;

    public static function getModel(): string
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return $model ?? (string) str(class_basename(static::class))
            ->beforeLast('Resource')
            ->prepend('App\\Models\\');
    }

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function getNavigationLabel(): string
    {
        return trans('filament-types::messages.title');
    }

    public static function getLabel(): ?string
    {
        return trans('filament-types::messages.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('filament-types::messages.title');
    }

    public static function getNavigationGroup(): ?string
    {
        return trans('filament-types::messages.group');
    }

    public static function form(Form $form): Form
    {
        return TypeForm::make($form);
    }

    public static function table(Table $table): Table
    {
        return TypeTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \TomatoPHP\FilamentTypes\Filament\Resources\TypeResource\Pages\ListTypes::route('/'),
        ];
    }
}
