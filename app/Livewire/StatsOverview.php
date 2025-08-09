<?php

namespace App\Livewire;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget {
    protected static ?string $pollingInterval = '10s';

    protected function getStats (): array {
        return [
            Stat::make('تعداد کاربران ثبت نام شده' , User::query()
                                                         ->count() . " نفر") ,
            Stat::make('تعداد اشتراک های خریداری شده' , Transaction::query()
                                                                   ->count() . " اشتراک") ,
        ];
    }
}
