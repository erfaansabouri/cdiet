<?php

namespace App\Filament\Resources\DietaryCookingCategoryResource\Pages;

use App\Filament\Resources\DietaryCookingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDietaryCookingCategories extends ListRecords
{
    protected static string $resource = DietaryCookingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
