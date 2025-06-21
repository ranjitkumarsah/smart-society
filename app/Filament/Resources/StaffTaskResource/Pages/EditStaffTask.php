<?php

namespace App\Filament\Resources\StaffTaskResource\Pages;

use App\Filament\Resources\StaffTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaffTask extends EditRecord
{
    protected static string $resource = StaffTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
