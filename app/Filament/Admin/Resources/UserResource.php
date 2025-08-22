<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers\FamiliesRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\ProfileRelationManager;
use App\Filament\Admin\Resources\UserResource\RelationManagers\WalletRelationManager;
use App\Models\User;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $modelLabel = 'کاربر';
    protected static ?string $pluralModelLabel = 'کاربران';
    protected static ?string $navigationGroup = 'مدیریت کاربران';
    protected static ?int $navigationSort = 1;

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'assign_role',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات اصلی')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('نام')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('family')
                            ->label('نام خانوادگی')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('mobile')
                            ->label('شماره موبایل')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(11),

                        Forms\Components\TextInput::make('password')
                            ->label('کلمه عبور')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255),

                        Forms\Components\Select::make('roles')
                            ->label('نقش‌ها')
                            ->relationship('roles', 'name')
                            ->preload()
                            ->multiple()
                            ->required()
                            ->searchable(),
                    ])->columns(2),

                Forms\Components\Section::make('اطلاعات تکمیلی')
                    ->relationship('profile')
                    ->schema([
                        Forms\Components\FileUpload::make('avatar')
                            ->label('تصویر پروفایل')
                            ->avatar()
                            ->image()
                            ->directory('avatars')
                            ->disk('public'),

                        Forms\Components\TextInput::make('national_code')
                            ->label('کدملی')
                            ->numeric()
                            ->length(10),

                        Forms\Components\TextInput::make('postal_code')
                            ->label('کدپستی')
                            ->numeric()
                            ->length(10),

                        Forms\Components\TextInput::make('province')
                            ->label('استان'),

                        Forms\Components\TextInput::make('address')
                            ->label('آدرس')
                            ->columnSpanFull(),

                        // استفاده از تاریخ جلالی
                        Forms\Components\DateTimePicker::make('birth')
                            ->label('تاریخ تولد')
                            ->jalali(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile.avatar')
                    ->label('تصویر')
                    ->circular()
                    ->disk('public'),

                Tables\Columns\TextColumn::make('name')
                    ->label('نام')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('family')
                    ->label('نام خانوادگی')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('mobile')
                    ->label('موبایل')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('نقش‌ها')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin' => 'primary',
                        'consultant' => 'success',
                        'marketer' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                // استفاده از تاریخ جلالی
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ثبت‌نام')
                    ->jalaliDateTime('Y/m/d H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('mobile_verified_at')
                    ->label('تایید موبایل')
                    ->jalaliDateTime('Y/m/d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('roles')
                    ->label('نقش')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

                Tables\Filters\Filter::make('mobile_verified')
                    ->label('تایید موبایل')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('mobile_verified_at')),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('از تاریخ'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('تا تاریخ'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('changeRoles')
                    ->label('تغییر نقش')
                    ->icon('heroicon-o-shield-check')
                    ->form([
                        Forms\Components\Select::make('roles')
                            ->label('نقش‌ها')
                            ->options(Role::all()->pluck('name', 'id'))
                            ->multiple()
                            ->required()
                            ->searchable(),
                    ])
                    ->action(function (User $record, array $data) {
                        $record->roles()->sync($data['roles']); // تغییر یافت
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('assignRole')
                        ->label('اختصاص نقش')
                        ->icon('heroicon-o-shield-check')
                        ->form([
                            Forms\Components\Select::make('role')
                                ->label('نقش')
                                ->options(Role::all()->pluck('name', 'id'))
                                ->required()
                                ->searchable(),
                        ])
                        ->action(function (array $data, $records) {
                            $role = Role::find($data['role']);
                            foreach ($records as $record) {
                                $record->assignRole($role);
                            }
                        }),

                    Tables\Actions\BulkAction::make('verifyMobile')
                        ->label('تایید موبایل')
                        ->icon('heroicon-o-check-circle')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['mobile_verified_at' => now()]);
                            }
                        })
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProfileRelationManager::class,
            FamiliesRelationManager::class,
            WalletRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            //'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
