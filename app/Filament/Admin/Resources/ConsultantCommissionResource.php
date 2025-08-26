<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ConsultantCommissionResource\Pages;
use App\Models\ConsultantCommission;
use App\Traits\HasRoleBasedNavigation;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ConsultantCommissionResource extends Resource
{
    use HasRoleBasedNavigation;

    protected static ?string $model = ConsultantCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'کمیسیون‌های مشاوران';

    protected static ?string $modelLabel = 'کمیسیون مشاور';

    protected static ?string $pluralModelLabel = 'کمیسیون‌های مشاوران';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 4;

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
                Tables\Columns\TextColumn::make('consultant.name')
                    ->label('مشاور')
                    ->getStateUsing(function (ConsultantCommission $record): string {
                        return $record->consultant->name.' '.$record->consultant->family;
                    })
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('test.title')
                    ->label('آزمون')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('test_amount')
                    ->label('مبلغ آزمون')
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
                    ->label('تاریخ تکمیل آزمون')
                    ->getStateUsing(function (ConsultantCommission $record): string {
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
                Tables\Filters\SelectFilter::make('consultant_id')
                    ->label('مشاور')
                    ->relationship('consultant', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('علامت‌گذاری به عنوان پرداخت شده')
                    ->action(function (ConsultantCommission $record) {
                        $record->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);
                    })
                    ->visible(fn (ConsultantCommission $record): bool => $record->status === 'pending')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('علامت‌گذاری چندگانه به عنوان پرداخت شده')
                        ->action(function (array $records) {
                            ConsultantCommission::whereIn('id', $records)
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
                Infolists\Components\Section::make('اطلاعات مشاور')
                    ->schema([
                        Infolists\Components\TextEntry::make('consultant.name')
                            ->label('نام مشاور')
                            ->getStateUsing(fn (ConsultantCommission $record): string => $record->consultant->name.' '.$record->consultant->family),
                        Infolists\Components\TextEntry::make('consultant.mobile')
                            ->label('شماره موبایل مشاور'),
                        Infolists\Components\TextEntry::make('commission_percentage')
                            ->label('درصد کمیسیون')
                            ->suffix('%'),
                    ])->columns(2),

                Infolists\Components\Section::make('اطلاعات آزمون')
                    ->schema([
                        Infolists\Components\TextEntry::make('test.title')
                            ->label('عنوان آزمون'),
                        Infolists\Components\TextEntry::make('attempt.completed_at')
                            ->label('تاریخ تکمیل آزمون')
                            ->getStateUsing(fn (ConsultantCommission $record): string => $record->attempt && $record->attempt->completed_at
                                ? $record->attempt->completed_at->format('Y/m/d H:i')
                                : '-'),
                        Infolists\Components\TextEntry::make('test_amount')
                            ->label('مبلغ آزمون')
                            ->getStateUsing(fn (ConsultantCommission $record): string => number_format($record->test_amount).' تومان'),
                        Infolists\Components\TextEntry::make('commission_amount')
                            ->label('مبلغ کمیسیون')
                            ->getStateUsing(fn (ConsultantCommission $record): string => number_format($record->commission_amount).' تومان'),
                    ])->columns(2),

                Infolists\Components\Section::make('وضعیت کمیسیون')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('وضعیت')
                            ->badge()
                            ->getStateUsing(fn (ConsultantCommission $record): string => match ($record->status) {
                                'pending' => 'در انتظار',
                                'paid' => 'پرداخت شده',
                                'cancelled' => 'لغو شده',
                                default => $record->status
                            })
                            ->color(fn (ConsultantCommission $record): string => match ($record->status) {
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
                            ->getStateUsing(fn (ConsultantCommission $record): string => $record->paid_at ? $record->paid_at->format('Y/m/d H:i') : '-'),
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
            'index' => Pages\ListConsultantCommissions::route('/'),
            'view' => Pages\ViewConsultantCommission::route('/{record}'),
            // Create and Edit pages removed - commissions are created automatically
        ];
    }
}
