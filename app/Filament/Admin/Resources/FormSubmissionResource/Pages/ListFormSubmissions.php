<?php

namespace App\Filament\Admin\Resources\FormSubmissionResource\Pages;

use App\Filament\Admin\Resources\FormSubmissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormSubmissions extends ListRecords
{
    protected static string $resource = FormSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
