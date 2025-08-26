<?php

namespace App\Filament\Admin\Resources\ConsultantCommissionResource\Pages;

use App\Filament\Admin\Resources\ConsultantCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConsultantCommission extends ViewRecord
{
    protected static string $resource = ConsultantCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_as_paid')
                ->label('علامت‌گذاری به عنوان پرداخت شده')
                ->action(function () {
                    $this->record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);
                })
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->requiresConfirmation(),
        ];
    }
}
