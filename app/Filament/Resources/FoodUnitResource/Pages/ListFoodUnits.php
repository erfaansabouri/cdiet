<?php

namespace App\Filament\Resources\FoodUnitResource\Pages;

use App\Filament\Resources\FoodUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFoodUnits extends ListRecords
{
    protected static string $resource = FoodUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
