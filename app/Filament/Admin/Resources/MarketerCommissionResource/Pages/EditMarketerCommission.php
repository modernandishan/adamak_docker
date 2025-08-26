<?php

namespace App\Filament\Admin\Resources\MarketerCommissionResource\Pages;

use App\Filament\Admin\Resources\MarketerCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMarketerCommission extends EditRecord
{
    protected static string $resource = MarketerCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
