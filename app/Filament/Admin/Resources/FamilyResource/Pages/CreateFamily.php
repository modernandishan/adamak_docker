<?php

namespace App\Filament\Admin\Resources\FamilyResource\Pages;

use App\Filament\Admin\Resources\FamilyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFamily extends CreateRecord
{
    protected static string $resource = FamilyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
