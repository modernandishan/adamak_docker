<?php

namespace App\Filament\Admin\Resources\ConsultantCommissionResource\Pages;

use App\Filament\Admin\Resources\ConsultantCommissionResource;
use Filament\Resources\Pages\ListRecords;

class ListConsultantCommissions extends ListRecords
{
    protected static string $resource = ConsultantCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction removed - commissions are created automatically
        ];
    }
}
