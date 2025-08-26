<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AutomaticCommissionResource\Pages;
use App\Models\AutomaticCommission;
use App\Traits\HasRoleBasedNavigation;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AutomaticCommissionResource extends Resource
{
    use HasRoleBasedNavigation;

    protected static ?string $model = AutomaticCommission::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'کمیسیون‌های خودکار';

    protected static ?string $modelLabel = 'کمیسیون خودکار';

    protected static ?string $pluralModelLabel = 'کمیسیون‌های خودکار';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        // فرم برای نمایش فقط - قابلیت ایجاد/ویرایش ندارد
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('type')
                    ->label('نوع')
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'marketer' => 'بازاریاب',
                            'consultant' => 'مشاور',
                            default => $state
                        };
                    })
                    ->colors([
                        'primary' => 'marketer',
                        'success' => 'consultant',
                    ]),
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('دریافت‌کننده')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('recipient_mobile')
                    ->label('شماره موبایل')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('test_title')
                    ->label('آزمون')
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
                Tables\Columns\TextColumn::make('earned_at')
                    ->label('تاریخ کسب کمیسیون')
                    ->formatStateUsing(function ($state) {
                        if ($state) {
                            return \Morilog\Jalali\Jalalian::fromDateTime($state)->format('Y/m/d H:i');
                        }

                        return '-';
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع')
                    ->options([
                        'marketer' => 'بازاریاب',
                        'consultant' => 'مشاور',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار',
                        'paid' => 'پرداخت شده',
                        'cancelled' => 'لغو شده',
                    ]),
                Tables\Filters\SelectFilter::make('recipient_id')
                    ->label('دریافت‌کننده')
                    ->relationship('recipient', 'name'),
                Tables\Filters\Filter::make('date_range')
                    ->label('بازه زمانی')
                    ->form([
                        \Filament\Forms\Components\DateTimePicker::make('from_date')
                            ->label('از تاریخ')
                            ->jalali(),
                        \Filament\Forms\Components\DateTimePicker::make('to_date')
                            ->label('تا تاریخ')
                            ->jalali(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['from_date'],
                                fn ($query) => $query->whereDate('earned_at', '>=', $data['from_date'])
                            )
                            ->when(
                                $data['to_date'],
                                fn ($query) => $query->whereDate('earned_at', '<=', $data['to_date'])
                            );
                    }),
                Tables\Filters\Filter::make('amount_range')
                    ->label('بازه مبلغ')
                    ->form([
                        \Filament\Forms\Components\TextInput::make('min_amount')
                            ->label('حداقل مبلغ')
                            ->numeric()
                            ->placeholder('0'),
                        \Filament\Forms\Components\TextInput::make('max_amount')
                            ->label('حداکثر مبلغ')
                            ->numeric()
                            ->placeholder('1000000'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['min_amount'],
                                fn ($query) => $query->where('commission_amount', '>=', $data['min_amount'])
                            )
                            ->when(
                                $data['max_amount'],
                                fn ($query) => $query->where('commission_amount', '<=', $data['max_amount'])
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('مشاهده جزئیات')
                    ->icon('heroicon-o-eye'),
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('علامت‌گذاری به عنوان پرداخت شده')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (AutomaticCommission $record) {
                        if ($record->type === 'marketer') {
                            $marketerCommission = \App\Models\MarketerCommission::find($record->source_id);
                            if ($marketerCommission) {
                                $marketerCommission->update([
                                    'status' => 'paid',
                                    'paid_at' => now(),
                                ]);
                            }
                        } else {
                            $consultantCommission = \App\Models\ConsultantCommission::find($record->source_id);
                            if ($consultantCommission) {
                                $consultantCommission->update([
                                    'status' => 'paid',
                                    'paid_at' => now(),
                                ]);
                            }
                        }
                    })
                    ->visible(fn (AutomaticCommission $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('تأیید پرداخت')
                    ->modalDescription('آیا می‌خواهید این کمیسیون را به عنوان پرداخت شده علامت‌گذاری کنید؟')
                    ->modalSubmitActionLabel('تأیید پرداخت')
                    ->modalCancelActionLabel('انصراف'),
                Tables\Actions\Action::make('mark_as_cancelled')
                    ->label('لغو کمیسیون')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->action(function (AutomaticCommission $record) {
                        if ($record->type === 'marketer') {
                            $marketerCommission = \App\Models\MarketerCommission::find($record->source_id);
                            if ($marketerCommission) {
                                $marketerCommission->update([
                                    'status' => 'cancelled',
                                ]);
                            }
                        } else {
                            $consultantCommission = \App\Models\ConsultantCommission::find($record->source_id);
                            if ($consultantCommission) {
                                $consultantCommission->update([
                                    'status' => 'cancelled',
                                ]);
                            }
                        }
                    })
                    ->visible(fn (AutomaticCommission $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('تأیید لغو')
                    ->modalDescription('آیا می‌خواهید این کمیسیون را لغو کنید؟ این عمل قابل بازگشت نیست.')
                    ->modalSubmitActionLabel('تأیید لغو')
                    ->modalCancelActionLabel('انصراف'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_paid')
                        ->label('علامت‌گذاری چندگانه به عنوان پرداخت شده')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (array $records) {
                            foreach ($records as $recordId) {
                                $record = AutomaticCommission::find($recordId);
                                if ($record && $record->status === 'pending') {
                                    if ($record->type === 'marketer') {
                                        $marketerCommission = \App\Models\MarketerCommission::find($record->source_id);
                                        if ($marketerCommission) {
                                            $marketerCommission->update([
                                                'status' => 'paid',
                                                'paid_at' => now(),
                                            ]);
                                        }
                                    } else {
                                        $consultantCommission = \App\Models\ConsultantCommission::find($record->source_id);
                                        if ($consultantCommission) {
                                            $consultantCommission->update([
                                                'status' => 'paid',
                                                'paid_at' => now(),
                                            ]);
                                        }
                                    }
                                }
                            }
                        })
                        ->requiresConfirmation()
                        ->modalHeading('تأیید پرداخت چندگانه')
                        ->modalDescription('آیا می‌خواهید تمام کمیسیون‌های انتخاب شده را به عنوان پرداخت شده علامت‌گذاری کنید؟')
                        ->modalSubmitActionLabel('تأیید پرداخت')
                        ->modalCancelActionLabel('انصراف')
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('mark_as_cancelled')
                        ->label('لغو چندگانه کمیسیون‌ها')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function (array $records) {
                            foreach ($records as $recordId) {
                                $record = AutomaticCommission::find($recordId);
                                if ($record && $record->status === 'pending') {
                                    if ($record->type === 'marketer') {
                                        $marketerCommission = \App\Models\MarketerCommission::find($record->source_id);
                                        if ($marketerCommission) {
                                            $marketerCommission->update([
                                                'status' => 'cancelled',
                                            ]);
                                        }
                                    } else {
                                        $consultantCommission = \App\Models\ConsultantCommission::find($record->source_id);
                                        if ($consultantCommission) {
                                            $consultantCommission->update([
                                                'status' => 'cancelled',
                                            ]);
                                        }
                                    }
                                }
                            }
                        })
                        ->requiresConfirmation()
                        ->modalHeading('تأیید لغو چندگانه')
                        ->modalDescription('آیا می‌خواهید تمام کمیسیون‌های انتخاب شده را لغو کنید؟ این عمل قابل بازگشت نیست.')
                        ->modalSubmitActionLabel('تأیید لغو')
                        ->modalCancelActionLabel('انصراف')
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('export_selected')
                        ->label('خروجی اکسل انتخاب شده‌ها')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->action(function (array $records) {
                            $selectedCommissions = AutomaticCommission::whereIn('id', $records)->get();

                            $filename = 'selected_commissions_'.now()->format('Y-m-d_H-i-s').'.csv';

                            $headers = [
                                'Content-Type' => 'text/csv; charset=UTF-8',
                                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                            ];

                            $callback = function () use ($selectedCommissions) {
                                $file = fopen('php://output', 'w');

                                // Add BOM for UTF-8
                                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                                // Headers
                                fputcsv($file, [
                                    'شناسه',
                                    'نوع',
                                    'نام دریافت‌کننده',
                                    'شماره موبایل',
                                    'عنوان آزمون',
                                    'مبلغ اصلی',
                                    'درصد کمیسیون',
                                    'مبلغ کمیسیون',
                                    'وضعیت',
                                    'تاریخ کسب کمیسیون',
                                    'تاریخ پرداخت',
                                ]);

                                // Data
                                foreach ($selectedCommissions as $commission) {
                                    fputcsv($file, [
                                        $commission->id,
                                        $commission->type === 'marketer' ? 'بازاریاب' : 'مشاور',
                                        $commission->recipient_name,
                                        $commission->recipient_mobile,
                                        $commission->test_title,
                                        number_format($commission->original_amount),
                                        $commission->commission_percentage.'%',
                                        number_format($commission->commission_amount),
                                        match ($commission->status) {
                                            'pending' => 'در انتظار',
                                            'paid' => 'پرداخت شده',
                                            'cancelled' => 'لغو شده',
                                            default => $commission->status
                                        },
                                        $commission->earned_at ? \Morilog\Jalali\Jalalian::fromDateTime($commission->earned_at)->format('Y/m/d H:i') : '-',
                                        $commission->paid_at ? \Morilog\Jalali\Jalalian::fromDateTime($commission->paid_at)->format('Y/m/d H:i') : '-',
                                    ]);
                                }

                                fclose($file);
                            };

                            return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('earned_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('اطلاعات دریافت‌کننده')
                    ->schema([
                        Infolists\Components\TextEntry::make('type')
                            ->label('نوع')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'marketer' => 'بازاریاب',
                                'consultant' => 'مشاور',
                                default => $state
                            })
                            ->color(fn (string $state): string => match ($state) {
                                'marketer' => 'primary',
                                'consultant' => 'success',
                                default => 'gray'
                            }),
                        Infolists\Components\TextEntry::make('recipient_name')
                            ->label('نام دریافت‌کننده'),
                        Infolists\Components\TextEntry::make('recipient_mobile')
                            ->label('شماره موبایل'),
                    ])->columns(2),

                Infolists\Components\Section::make('اطلاعات آزمون')
                    ->schema([
                        Infolists\Components\TextEntry::make('test_title')
                            ->label('عنوان آزمون'),
                        Infolists\Components\TextEntry::make('original_amount')
                            ->label('مبلغ آزمون')
                            ->getStateUsing(fn (AutomaticCommission $record): string => number_format($record->original_amount).' تومان'),
                        Infolists\Components\TextEntry::make('commission_percentage')
                            ->label('درصد کمیسیون')
                            ->suffix('%'),
                        Infolists\Components\TextEntry::make('commission_amount')
                            ->label('مبلغ کمیسیون')
                            ->getStateUsing(fn (AutomaticCommission $record): string => number_format($record->commission_amount).' تومان'),
                    ])->columns(2),

                Infolists\Components\Section::make('وضعیت کمیسیون')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('وضعیت')
                            ->badge()
                            ->formatStateUsing(fn (AutomaticCommission $record): string => match ($record->status) {
                                'pending' => 'در انتظار',
                                'paid' => 'پرداخت شده',
                                'cancelled' => 'لغو شده',
                                default => $record->status
                            })
                            ->color(fn (AutomaticCommission $record): string => match ($record->status) {
                                'pending' => 'warning',
                                'paid' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray'
                            }),
                        Infolists\Components\TextEntry::make('earned_at')
                            ->label('تاریخ کسب کمیسیون')
                            ->formatStateUsing(function ($state) {
                                if ($state) {
                                    return \Morilog\Jalali\Jalalian::fromDateTime($state)->format('Y/m/d H:i');
                                }

                                return '-';
                            }),
                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('تاریخ پرداخت')
                            ->getStateUsing(function (AutomaticCommission $record): string {
                                if ($record->paid_at) {
                                    return \Morilog\Jalali\Jalalian::fromDateTime($record->paid_at)->format('Y/m/d H:i');
                                }

                                return '-';
                            }),
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
            'index' => Pages\ListAutomaticCommissions::route('/'),
            'view' => Pages\ViewAutomaticCommission::route('/{record}'),
            // Create and Edit pages removed - commissions are created automatically
        ];
    }
}
