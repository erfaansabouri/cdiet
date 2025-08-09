<?php

namespace App\Filament\Resources\DietaryCookingCategoryResource\Pages;

use App\Filament\Resources\DietaryCookingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDietaryCookingCategory extends EditRecord
{
    protected static string $resource = DietaryCookingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
