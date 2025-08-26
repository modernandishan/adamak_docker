<?php

namespace App\Filament\Admin\Resources\ConsultantBiographyResource\Pages;

use App\Filament\Admin\Resources\ConsultantBiographyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditConsultantBiography extends EditRecord
{
    protected static string $resource = ConsultantBiographyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
