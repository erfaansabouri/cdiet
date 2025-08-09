<?php

namespace App\Filament\Resources\MealtimeResource\Pages;

use App\Filament\Resources\MealtimeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMealtime extends EditRecord
{
    protected static string $resource = MealtimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
