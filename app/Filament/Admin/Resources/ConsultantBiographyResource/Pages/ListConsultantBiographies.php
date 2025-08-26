<?php

namespace App\Filament\Admin\Resources\ConsultantBiographyResource\Pages;

use App\Filament\Admin\Resources\ConsultantBiographyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListConsultantBiographies extends ListRecords
{
    protected static string $resource = ConsultantBiographyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
