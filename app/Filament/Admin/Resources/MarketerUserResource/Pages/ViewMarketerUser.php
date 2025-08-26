<?php

namespace App\Filament\Admin\Resources\MarketerUserResource\Pages;

use App\Filament\Admin\Resources\MarketerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMarketerUser extends ViewRecord
{
    protected static string $resource = MarketerUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
