<?php

namespace App\Filament\Admin\Resources\MarketerCommissionResource\Pages;

use App\Filament\Admin\Resources\MarketerCommissionResource;
use Filament\Resources\Pages\ListRecords;

class ListMarketerCommissions extends ListRecords
{
    protected static string $resource = MarketerCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction removed - commissions are created automatically
        ];
    }
}
