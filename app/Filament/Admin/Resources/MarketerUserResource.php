<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MarketerUserResource\Pages;
use App\Models\User;
use App\Traits\HasRoleBasedNavigation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MarketerUserResource extends Resource
{
    use HasRoleBasedNavigation;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'مدیریت بازاریاب‌ها';

    protected static ?string $modelLabel = 'بازاریاب';

    protected static ?string $pluralModelLabel = 'بازاریاب‌ها';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('نام')
                    ->required(),
                Forms\Components\TextInput::make('family')
                    ->label('نام خانوادگی')
                    ->required(),
                Forms\Components\TextInput::make('mobile')
                    ->label('شماره موبایل')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('commission_percentage')
                    ->label('درصد کمیسیون')
                    ->numeric()
                    ->suffix('%')
                    ->default(10)
                    ->required(),
                Forms\Components\Select::make('roles')
                    ->label('نقش‌ها')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('family')
                    ->label('نام خانوادگی')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->label('شماره موبایل')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('commission_percentage')
                    ->label('درصد کمیسیون')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('referrals_count')
                    ->label('تعداد معرفی‌ها')
                    ->counts('referrals')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_commission')
                    ->label('کل کمیسیون')
                    ->getStateUsing(function (User $record): string {
                        $total = $record->commissions->sum('commission_amount');

                        return number_format($total).' تومان';
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ عضویت')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('اطلاعات بازاریاب')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('نام'),
                        Infolists\Components\TextEntry::make('family')
                            ->label('نام خانوادگی'),
                        Infolists\Components\TextEntry::make('mobile')
                            ->label('شماره موبایل'),
                        Infolists\Components\TextEntry::make('commission_percentage')
                            ->label('درصد کمیسیون')
                            ->suffix('%'),
                        Infolists\Components\TextEntry::make('referral_token')
                            ->label('توکن معرفی')
                            ->copyable(),
                    ])->columns(2),

                Infolists\Components\Section::make('آمار معرفی')
                    ->schema([
                        Infolists\Components\TextEntry::make('referrals_count')
                            ->label('تعداد کلیک‌های معرفی')
                            ->getStateUsing(fn (User $record): int => $record->referrals()->count()),
                        Infolists\Components\TextEntry::make('successful_referrals_count')
                            ->label('تعداد معرفی‌های موفق')
                            ->getStateUsing(fn (User $record): int => $record->referrals()->whereNotNull('referred_user_id')->count()),
                        Infolists\Components\TextEntry::make('total_commission_amount')
                            ->label('کل کمیسیون کسب شده')
                            ->getStateUsing(function (User $record): string {
                                $total = $record->commissions()->sum('commission_amount');

                                return number_format($total).' تومان';
                            }),
                        Infolists\Components\TextEntry::make('pending_commission')
                            ->label('کمیسیون در انتظار')
                            ->getStateUsing(function (User $record): string {
                                $pending = $record->commissions()->where('status', 'pending')->sum('commission_amount');

                                return number_format($pending).' تومان';
                            }),
                    ])->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Admin\Resources\MarketerUserResource\RelationManagers\ReferralsRelationManager::class,
            \App\Filament\Admin\Resources\MarketerUserResource\RelationManagers\CommissionsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereHas('roles', function (Builder $query) {
            $query->where('name', 'marketer');
        });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMarketerUsers::route('/'),
            'create' => Pages\CreateMarketerUser::route('/create'),
            'view' => Pages\ViewMarketerUser::route('/{record}'),
            'edit' => Pages\EditMarketerUser::route('/{record}/edit'),
        ];
    }
}
