<?php

namespace App\Filament\Resources\RecommendedMealResource\Pages;

use App\Filament\Resources\RecommendedMealResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecommendedMeal extends EditRecord
{
    protected static string $resource = RecommendedMealResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
