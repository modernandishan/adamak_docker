<?php

namespace App\Filament\Admin\Resources\MarketerUserResource\Pages;

use App\Filament\Admin\Resources\MarketerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMarketerUsers extends ListRecords
{
    protected static string $resource = MarketerUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
