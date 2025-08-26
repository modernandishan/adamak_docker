<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ConsultantBiographyResource\Pages;
use App\Models\ConsultantBiography;
use App\Services\ConsultantAssignmentService;
use App\Traits\HasRoleBasedNavigation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConsultantBiographyResource extends Resource
{
    use HasRoleBasedNavigation;

    protected static ?string $model = ConsultantBiography::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $modelLabel = 'مشاور';

    protected static ?string $pluralModelLabel = 'مدیریت مشاوران';

    protected static ?string $navigationLabel = 'مدیریت مشاوران';

    protected static ?string $navigationGroup = 'مدیریت کاربران';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('کاربر')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('professional_title')
                    ->label('عنوان شغلی')
                    ->maxLength(255),
                Forms\Components\TextInput::make('priority')
                    ->label('اولویت تخصیص')
                    ->helperText('عدد بزرگتر = احتمال بیشتر برای تخصیص آزمون')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(100)
                    ->default(1),
                Forms\Components\Toggle::make('is_public')
                    ->label('نمایش عمومی')
                    ->default(true),
                Forms\Components\Textarea::make('bio')
                    ->label('بیوگرافی')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('phone')
                    ->label('تلفن تماس')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('ایمیل')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('test_commission_percentage')
                    ->label('درصد کمیسیون آزمون')
                    ->helperText('درصدی از هزینه آزمون که به مشاور تعلق می‌گیرد (پیش‌فرض: 50%)')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(50.00)
                    ->suffix('%'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('نام مشاور')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('professional_title')
                    ->label('عنوان شغلی')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('priority')
                    ->label('اولویت تخصیص')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state >= 10 => 'success',
                        $state >= 5 => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('is_public')
                    ->label('نمایش عمومی')
                    ->boolean(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('تلفن')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('ایمیل')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('test_commission_percentage')
                    ->label('درصد کمیسیون آزمون')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_public')
                    ->label('نمایش عمومی'),
                Tables\Filters\Filter::make('high_priority')
                    ->label('اولویت بالا')
                    ->query(fn (Builder $query) => $query->where('priority', '>=', 10)),
            ])
            ->defaultSort('priority', 'desc')
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('ویرایش'),
                Tables\Actions\Action::make('manage_priority')
                    ->label('تغییر اولویت')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->form([
                        Forms\Components\TextInput::make('priority')
                            ->label('اولویت جدید')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(100)
                            ->required(),
                    ])
                    ->action(function (ConsultantBiography $record, array $data): void {
                        $record->update(['priority' => $data['priority']]);
                    })
                    ->successNotificationTitle('اولویت با موفقیت به‌روزرسانی شد'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('assignment_stats')
                    ->label('آمار تخصیص آزمون‌ها')
                    ->icon('heroicon-o-chart-bar')
                    ->modalHeading('آمار تخصیص آزمون‌ها به مشاوران')
                    ->modalContent(function () {
                        $service = new ConsultantAssignmentService;
                        $stats = $service->getAssignmentStatistics();

                        if (empty($stats)) {
                            return view('filament.pages.no-assignments');
                        }

                        return view('filament.pages.assignment-stats', compact('stats'));
                    })
                    ->modalWidth('5xl'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListConsultantBiographies::route('/'),
            'create' => Pages\CreateConsultantBiography::route('/create'),
            'edit' => Pages\EditConsultantBiography::route('/{record}/edit'),
        ];
    }
}
