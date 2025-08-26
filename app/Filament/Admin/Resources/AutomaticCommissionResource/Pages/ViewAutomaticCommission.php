<?php

namespace App\Filament\Admin\Resources\AutomaticCommissionResource\Pages;

use App\Filament\Admin\Resources\AutomaticCommissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAutomaticCommission extends ViewRecord
{
    protected static string $resource = AutomaticCommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_as_paid')
                ->label('علامت‌گذاری به عنوان پرداخت شده')
                ->action(function () {
                    if ($this->record->type === 'marketer') {
                        $marketerCommission = \App\Models\MarketerCommission::find($this->record->source_id);
                        if ($marketerCommission) {
                            $marketerCommission->update([
                                'status' => 'paid',
                                'paid_at' => now(),
                            ]);
                        }
                    } else {
                        $consultantCommission = \App\Models\ConsultantCommission::find($this->record->source_id);
                        if ($consultantCommission) {
                            $consultantCommission->update([
                                'status' => 'paid',
                                'paid_at' => now(),
                            ]);
                        }
                    }
                })
                ->visible(fn (): bool => $this->record->status === 'pending')
                ->requiresConfirmation(),
        ];
    }
}
