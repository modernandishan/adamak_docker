<?php

namespace App\Filament\Admin\Resources\MarketerUserResource\RelationManagers;

use App\Models\MarketerCommission;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CommissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'commissions';

    protected static ?string $title = 'کمیسیون‌ها';

    public function isReadOnly(): bool
    {
        return false;
    }

    public static function canViewForRecord(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }

    protected function canCreate(): bool
    {
        return false;
    }

    protected function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        // فرم برای نمایش فقط - قابلیت ایجاد/ویرایش ندارد
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('commission_source')
            ->columns([
                Tables\Columns\TextColumn::make('referredUser.name')
                    ->label('کاربر معرفی شده')
                    ->getStateUsing(function (MarketerCommission $record): string {
                        if ($record->referredUser) {
                            return $record->referredUser->name.' '.$record->referredUser->family;
                        }

                        return '-';
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('attempt.test.title')
                    ->label('آزمون')
                    ->getStateUsing(function (MarketerCommission $record): string {
                        if ($record->commission_source === 'test_purchase' && $record->attempt && $record->attempt->test) {
                            return $record->attempt->test->title;
                        }

                        return '-';
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('original_amount')
                    ->label('مبلغ اصلی')
                    ->formatStateUsing(fn (string $state): string => number_format($state).' تومان')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_percentage')
                    ->label('درصد کمیسیون')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_amount')
                    ->label('مبلغ کمیسیون')
                    ->formatStateUsing(fn (string $state): string => number_format($state).' تومان')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'pending' => 'در انتظار',
                            'paid' => 'پرداخت شده',
                            'cancelled' => 'لغو شده',
                            default => $state
                        };
                    }),
                Tables\Columns\TextColumn::make('earned_at')
                    ->label('تاریخ کسب')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                    ]),
            ])
            ->headerActions([
                // فقط نمایش - امکان ایجاد ندارد
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('علامت‌گذاری به عنوان پرداخت شده')
                    ->action(function (MarketerCommission $record) {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);
                    })
                    ->visible(fn (MarketerCommission $record): bool => $record->status === 'pending')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('علامت‌گذاری به عنوان پرداخت شده')
                        ->action(function (array $records) {
                            MarketerCommission::whereIn('id', $records)->update([
                                'status' => 'paid',
                                'paid_at' => now(),
                            ]);
                        })
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('earned_at', 'desc');
    }
}
