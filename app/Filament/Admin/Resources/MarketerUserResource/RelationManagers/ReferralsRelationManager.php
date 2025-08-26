<?php

namespace App\Filament\Admin\Resources\MarketerUserResource\RelationManagers;

use App\Models\Referral;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ReferralsRelationManager extends RelationManager
{
    protected static string $relationship = 'referrals';

    protected static ?string $title = 'کاربران معرفی شده';

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
        return $form
            ->schema([
                Forms\Components\TextInput::make('referral_token')
                    ->label('توکن معرفی')
                    ->disabled(),
                Forms\Components\TextInput::make('visitor_ip')
                    ->label('IP بازدیدکننده')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('clicked_at')
                    ->label('زمان کلیک')
                    ->disabled(),
                Forms\Components\DateTimePicker::make('registered_at')
                    ->label('زمان ثبت نام')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('referral_token')
            ->columns([
                Tables\Columns\TextColumn::make('referral_token')
                    ->label('توکن معرفی')
                    ->searchable(),
                Tables\Columns\TextColumn::make('referredUser.name')
                    ->label('کاربر معرفی شده')
                    ->getStateUsing(function (Referral $record): string {
                        if ($record->referredUser) {
                            return $record->referredUser->name.' '.$record->referredUser->family;
                        }

                        return '-';
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('referredUser.mobile')
                    ->label('شماره موبایل')
                    ->getStateUsing(function (Referral $record): string {
                        return $record->referredUser->mobile ?? '-';
                    }),
                Tables\Columns\TextColumn::make('visitor_ip')
                    ->label('IP بازدیدکننده'),
                Tables\Columns\TextColumn::make('clicked_at')
                    ->label('زمان کلیک')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('registered_at')
                    ->label('زمان ثبت نام')
                    ->dateTime(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('وضعیت')
                    ->getStateUsing(function (Referral $record): string {
                        if ($record->referred_user_id) {
                            return 'ثبت نام شده';
                        }

                        return 'در انتظار';
                    })
                    ->colors([
                        'success' => 'ثبت نام شده',
                        'warning' => 'در انتظار',
                    ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('registered')
                    ->label('ثبت نام شده‌ها')
                    ->query(fn ($query) => $query->whereNotNull('referred_user_id')),
                Tables\Filters\Filter::make('pending')
                    ->label('در انتظار')
                    ->query(fn ($query) => $query->whereNull('referred_user_id')),
            ])
            ->headerActions([
                // فقط نمایش - امکان ایجاد ندارد
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                // فقط نمایش - امکان حذف دسته‌ای ندارد
            ])
            ->defaultSort('clicked_at', 'desc');
    }
}
