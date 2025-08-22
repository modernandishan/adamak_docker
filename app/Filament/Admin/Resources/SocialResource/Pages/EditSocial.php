<?php

namespace App\Filament\Admin\Resources\SocialResource\Pages;

use App\Filament\Admin\Resources\SocialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocial extends EditRecord
{
    protected static string $resource = SocialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
