<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FormSubmissionResource\Pages;
use App\Models\FormSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FormSubmissionResource extends Resource
{
    protected static ?string $model = FormSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $modelLabel = 'درخواست';

    protected static ?string $pluralModelLabel = 'درخواست‌ها';

    protected static ?string $navigationGroup = 'مدیریت فرم‌ها';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('اطلاعات اصلی')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('کاربر')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('نوع درخواست')
                            ->options([
                                'consultant' => 'مشاوره',
                                'marketer' => 'بازاریابی',
                                'recruitment' => 'جذب نیرو',
                                // انواع دیگر فرم‌ها را اینجا اضافه کنید
                            ])
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('وضعیت')
                            ->options([
                                'pending' => 'در انتظار بررسی',
                                'approved' => 'تایید شده',
                                'rejected' => 'رد شده',
                            ])
                            ->default('pending')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('جزئیات درخواست')
                    ->description('اطلاعات ارسالی توسط کاربر')
                    ->schema([
                        Forms\Components\KeyValue::make('data')
                            ->keyLabel('فیلد')
                            ->valueLabel('مقدار')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('data.resume_path')
                            ->label('مسیر رزومه')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('تاریخ‌ها')
                    ->schema([
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('تاریخ ایجاد')
                            ->displayFormat('d/m/Y H:i')
                            ->disabled(),

                        Forms\Components\DateTimePicker::make('updated_at')
                            ->label('آخرین بروزرسانی')
                            ->displayFormat('d/m/Y H:i')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'consultant' => 'مشاوره',
                        'marketer' => 'بازاریابی',
                        'recruitment' => 'جذب نیرو',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'consultant' => 'primary',
                        'marketer' => 'info',
                        'recruitment' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'در انتظار',
                        'approved' => 'تایید شده',
                        'rejected' => 'رد شده',
                    })
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ارسال')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین تغییر')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع درخواست')
                    ->options([
                        'consultant' => 'مشاوره',
                        'marketer' => 'بازاریابی',
                        'recruitment' => 'جذب نیرو',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'pending' => 'در انتظار',
                        'approved' => 'تایید شده',
                        'rejected' => 'رد شده',
                    ]),

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
                Tables\Actions\Action::make('downloadResume')
                    ->label('دانلود رزومه')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn (FormSubmission $record): string => isset($record->data['resume_path'])
                        ? asset('storage/'.$record->data['resume_path'])
                        : '#')
                    ->openUrlInNewTab()
                    ->visible(fn (FormSubmission $record): bool => isset($record->data['resume_path']) && ! empty($record->data['resume_path'])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\BulkAction::make('changeStatus')
                        ->label('تغییر وضعیت')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('وضعیت جدید')
                                ->options([
                                    'approved' => 'تایید شده',
                                    'rejected' => 'رد شده',
                                ])
                                ->required(),
                        ])
                        ->action(function (array $data, $records) {
                            foreach ($records as $record) {
                                $record->update(['status' => $data['status']]);
                            }
                        }),
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
            'index' => Pages\ListFormSubmissions::route('/'),
            'create' => Pages\CreateFormSubmission::route('/create'),
            // 'view' => Pages\ViewFormSubmission::route('/{record}'),
            'edit' => Pages\EditFormSubmission::route('/{record}/edit'),
        ];
    }
}
