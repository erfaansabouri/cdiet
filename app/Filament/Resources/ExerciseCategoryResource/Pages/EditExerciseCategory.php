<?php

namespace App\Filament\Resources\ExerciseCategoryResource\Pages;

use App\Filament\Resources\ExerciseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExerciseCategory extends EditRecord
{
    protected static string $resource = ExerciseCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
