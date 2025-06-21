<?php

namespace App\Filament\resident\Resources\FamilyMemberResource\Pages;

use App\Filament\resident\Resources\FamilyMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyMember extends EditRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];

        
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['resident_id'] = auth()->id();
        return $data;
    }
}
