<?php

namespace App\Filament\Resources\StaffTaskResource\Pages;

use App\Filament\Resources\StaffTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffTasks extends ListRecords
{
    protected static string $resource = StaffTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
