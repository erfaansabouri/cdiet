<?php

namespace App\Filament\Pages;

use App\Livewire\StatsOverview;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget;

class Dashboard extends \Filament\Pages\Dashboard {
    public function getWidgets (): array {
        return [
            StatsOverview::class
        ];
    }
}
