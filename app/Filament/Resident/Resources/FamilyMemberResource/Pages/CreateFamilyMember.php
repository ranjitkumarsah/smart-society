<?php

namespace App\Filament\resident\Resources\FamilyMemberResource\Pages;

use App\Filament\resident\Resources\FamilyMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFamilyMember extends CreateRecord
{
    protected static string $resource = FamilyMemberResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['resident_id'] = auth()->id();
        return $data;
    }
}
