<?php

namespace App\Filament\Resources\DietaryCookingResource\Pages;

use App\Filament\Resources\DietaryCookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDietaryCookings extends ListRecords
{
    protected static string $resource = DietaryCookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
