<?php

namespace App\Filament\Resources\FoodUnitResource\Pages;

use App\Filament\Resources\FoodUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFoodUnit extends EditRecord
{
    protected static string $resource = FoodUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
