<?php

namespace App\Filament\Resources\RecommendedMealResource\Pages;

use App\Filament\Resources\RecommendedMealResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecommendedMeals extends ListRecords
{
    protected static string $resource = RecommendedMealResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
