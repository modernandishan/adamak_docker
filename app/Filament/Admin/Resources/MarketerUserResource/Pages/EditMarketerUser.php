<?php

namespace App\Filament\Admin\Resources\MarketerUserResource\Pages;

use App\Filament\Admin\Resources\MarketerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketerUser extends EditRecord
{
    protected static string $resource = MarketerUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
