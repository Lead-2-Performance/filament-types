<?php

namespace TomatoPHP\FilamentTypes\Filament\Resources\TypeResource\Actions\Components;

use Filament\Actions;
use Filament\Notifications\Notification;

class CreateAction extends Action
{
    public static function make(): Actions\Action
    {
        $model = config('filament-types.model') ?? \TomatoPHP\FilamentTypes\Models\Type::class;
        return Actions\CreateAction::make()
            ->label(trans('filament-types::messages.create'))
            ->using(function (array $data) use ($model) {
                $checkExistsType = $model::query()
                    ->where('key', $data['key'])
                    ->where('for', $data['for'])
                    ->where('type', $data['type'])
                    ->first();

                if ($checkExistsType) {
                    Notification::make()
                        ->title(trans('filament-types::messages.exists'))
                        ->danger()
                        ->send();

                    return $checkExistsType;
                } else {
                    $type = $model::create($data);

                    Notification::make()
                        ->title(trans('filament-types::messages.success'))
                        ->success()
                        ->send();

                    return $type;
                }
            })
            ->successNotification(null);
    }
}
