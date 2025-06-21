<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminWidgets extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Residents', 125),
            Stat::make('Total Guards', 125),
            Stat::make('Total Staffs', 125),
            Stat::make('Total Visitors', 125),
        ];
    }
}
