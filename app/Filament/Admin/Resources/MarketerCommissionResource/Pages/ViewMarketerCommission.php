<?php

namespace App\Filament\Admin\Resources\MarketerCommissionResource\Pages;

use App\Filament\Admin\Resources\MarketerCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMarketerCommission extends ViewRecord
{
    protected static string $resource = MarketerCommissionResource::class;

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

                    $this->redirect($this->getResource()::getUrl('index'));
                })
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->requiresConfirmation()
                ->color('success'),
        ];
    }
}
