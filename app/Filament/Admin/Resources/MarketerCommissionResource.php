<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MarketerCommissionResource\Pages;
use App\Models\MarketerCommission;
use App\Traits\HasRoleBasedNavigation;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MarketerCommissionResource extends Resource
{
    use HasRoleBasedNavigation;

    protected static ?string $model = MarketerCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'کمیسیون‌های خودکار';

    protected static ?string $modelLabel = 'کمیسیون';

    protected static ?string $pluralModelLabel = 'کمیسیون‌ها';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return false; // Hidden - now part of unified AutomaticCommissionResource
    }

    public static function form(Form $form): Form
    {
        // فرم برای نمایش فقط - قابلیت ایجاد/ویرایش ندارد
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('marketer.name')
                    ->label('بازاریاب')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('referredUser.name')
                    ->label('کاربر معرفی شده')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('attempt.test.title')
                    ->label('آزمون')
                    ->getStateUsing(function (MarketerCommission $record): string {
                        if ($record->commission_source === 'test_purchase' && $record->attempt && $record->attempt->test) {
                            return $record->attempt->test->title;
                        }

                        return '-';
                    })
                    ->searchable()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('attempt.completed_at')
                    ->label('تاریخ انجام آزمون')
                    ->getStateUsing(function (MarketerCommission $record): string {
                        if ($record->attempt && $record->attempt->completed_at) {
                            return $record->attempt->completed_at->format('Y/m/d H:i');
                        }

                        return '-';
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('earned_at')
                    ->label('تاریخ کسب کمیسیون')
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
                Tables\Filters\SelectFilter::make('marketer_id')
                    ->label('بازاریاب')
                    ->relationship('marketer', 'name'),
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
                        ->label('علامت‌گذاری چندگانه به عنوان پرداخت شده')
                        ->action(function (array $records) {
                            MarketerCommission::whereIn('id', $records)
                                ->where('status', 'pending')
                                ->update([
                                    'status' => 'paid',
                                    'paid_at' => now(),
                                ]);
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('earned_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('اطلاعات بازاریاب')
                    ->schema([
                        Infolists\Components\TextEntry::make('marketer.name')
                            ->label('نام بازاریاب')
                            ->getStateUsing(fn (MarketerCommission $record): string => $record->marketer->name.' '.$record->marketer->family),
                        Infolists\Components\TextEntry::make('marketer.mobile')
                            ->label('شماره موبایل بازاریاب'),
                        Infolists\Components\TextEntry::make('commission_percentage')
                            ->label('درصد کمیسیون')
                            ->suffix('%'),
                    ])->columns(2),

                Infolists\Components\Section::make('اطلاعات کاربر معرفی شده')
                    ->schema([
                        Infolists\Components\TextEntry::make('referredUser.name')
                            ->label('نام کاربر')
                            ->getStateUsing(fn (MarketerCommission $record): string => $record->referredUser->name.' '.$record->referredUser->family),
                        Infolists\Components\TextEntry::make('referredUser.mobile')
                            ->label('شماره موبایل کاربر'),
                    ])->columns(2),

                Infolists\Components\Section::make('جزئیات آزمون')
                    ->schema([
                        Infolists\Components\TextEntry::make('attempt.test.title')
                            ->label('عنوان آزمون')
                            ->getStateUsing(fn (MarketerCommission $record): string => $record->attempt->test->title ?? '-'),
                        Infolists\Components\TextEntry::make('attempt.completed_at')
                            ->label('تاریخ انجام آزمون')
                            ->getStateUsing(fn (MarketerCommission $record): string => $record->attempt && $record->attempt->completed_at
                                    ? $record->attempt->completed_at->format('Y/m/d H:i')
                                    : '-'),
                        Infolists\Components\TextEntry::make('original_amount')
                            ->label('مبلغ پرداخت شده')
                            ->getStateUsing(fn (MarketerCommission $record): string => number_format($record->original_amount).' تومان'),
                        Infolists\Components\TextEntry::make('commission_amount')
                            ->label('مبلغ کمیسیون')
                            ->getStateUsing(fn (MarketerCommission $record): string => number_format($record->commission_amount).' تومان'),
                    ])->columns(2),

                Infolists\Components\Section::make('وضعیت کمیسیون')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('وضعیت')
                            ->badge()
                            ->getStateUsing(fn (MarketerCommission $record): string => match ($record->status) {
                                'pending' => 'در انتظار',
                                'paid' => 'پرداخت شده',
                                'cancelled' => 'لغو شده',
                                default => $record->status
                            })
                            ->color(fn (MarketerCommission $record): string => match ($record->status) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray'
                            }),
                        Infolists\Components\TextEntry::make('earned_at')
                            ->label('تاریخ کسب کمیسیون')
                            ->dateTime(),
                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('تاریخ پرداخت')
                            ->getStateUsing(fn (MarketerCommission $record): string => $record->paid_at ? $record->paid_at->format('Y/m/d H:i') : '-'),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketerCommissions::route('/'),
            'view' => Pages\ViewMarketerCommission::route('/{record}'),
            // Create and Edit pages removed - commissions are created automatically
        ];
    }
}
