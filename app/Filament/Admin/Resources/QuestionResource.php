<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Support\Enums\FontWeight;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationLabel = 'سوالات';
    protected static ?string $pluralLabel = 'سوالات';
    protected static ?string $label = 'سوال';
    protected static ?string $navigationGroup = 'مدیریت آزمون‌ها';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(12)
                    ->schema([
                        // بخش اصلی فرم - 8 ستون
                        Forms\Components\Grid::make(1)
                            ->columnSpan(8)
                            ->schema([
                                // بخش اطلاعات اصلی سوال
                                Forms\Components\Section::make('اطلاعات اصلی سوال')
                                    ->description('اطلاعات پایه و محتوای سوال را در این بخش وارد کنید')
                                    ->icon('heroicon-o-document-text')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('test_id')
                                                    ->label('آزمون مرتبط')
                                                    ->relationship('test', 'title')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->placeholder('آزمون مورد نظر را انتخاب کنید'),

                                                Forms\Components\Select::make('type')
                                                    ->label('نوع سوال')
                                                    ->options(Question::getTypes())
                                                    ->required()
                                                    ->native(false)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (Set $set, $state) {
                                                        // پاک کردن فیلدها هنگام تغییر نوع
                                                        $set('options', null);
                                                        $set('settings', null);

                                                        // تنظیم مقادیر پیش‌فرض براساس نوع
                                                        if ($state === 'true_false') {
                                                            $set('options', [
                                                                ['text' => 'درست', 'value' => 'true'],
                                                                ['text' => 'غلط', 'value' => 'false']
                                                            ]);
                                                        }
                                                    })
                                                    ->placeholder('نوع سوال را انتخاب کنید'),
                                            ]),

                                        Forms\Components\TextInput::make('title')
                                            ->label('عنوان سوال')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->placeholder('عنوان سوال را وارد کنید')
                                            ->columnSpanFull(),

                                        TiptapEditor::make('description')
                                            ->label('شرح و محتوای سوال')
                                            ->placeholder('شرح کامل سوال، راهنمایی‌ها و توضیحات لازم را وارد کنید')
                                            ->extraInputAttributes(['style' => 'min-height: 15rem;'])
                                            ->output(TiptapOutput::Html)
                                            ->columnSpanFull(),
                                    ]),

                                // بخش گزینه‌ها و تنظیمات نوع سوال
                                Forms\Components\Section::make('گزینه‌ها و تنظیمات')
                                    ->description('گزینه‌های سوال و تنظیمات خا�� هر نوع سوال')
                                    ->icon('heroicon-o-list-bullet')
                                    ->collapsible()
                                    ->collapsed(fn (Get $get): bool => !in_array($get('type'), ['multiple_choice', 'single_choice', 'true_false']))
                                    ->schema([
                                        // گزینه‌های سوالات چندگزینه‌ای
                                        Forms\Components\Repeater::make('options')
                                            ->label('گزینه‌های سوال')
                                            ->schema([
                                                Forms\Components\Grid::make(3)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('text')
                                                            ->label('متن گزینه')
                                                            ->required()
                                                            ->columnSpan(2)
                                                            ->placeholder('متن گزینه را وارد کنید'),

                                                        Forms\Components\TextInput::make('value')
                                                            ->label('مقدار')
                                                            ->placeholder('مقدار عددی')
                                                            ->columnSpan(1),
                                                    ]),
                                            ])
                                            ->addAction(
                                                fn (Forms\Components\Actions\Action $action) => $action->label('افزودن گزینه جدید')
                                            )
                                            ->deleteAction(
                                                fn (Forms\Components\Actions\Action $action) => $action->label('حذف گزینه')
                                            )
                                            ->reorderAction(
                                                fn (Forms\Components\Actions\Action $action) => $action->label('تغییر ترتیب')
                                            )
                                            ->minItems(fn (Get $get): int =>
                                            $get('type') === 'true_false' ? 2 :
                                                (in_array($get('type'), ['multiple_choice', 'single_choice']) ? 2 : 0)
                                            )
                                            ->maxItems(fn (Get $get): int =>
                                            $get('type') === 'true_false' ? 2 : 20
                                            )
                                            ->visible(fn (Get $get): bool =>
                                            in_array($get('type'), ['multiple_choice', 'single_choice', 'true_false'])
                                            )
                                            ->live()
                                            ->collapsible()
                                            ->itemLabel(fn (array $state): ?string => $state['text'] ?? null),

                                        // تنظیمات اضافی براساس نوع سوال - بدون collapsible/collapsed
                                        Forms\Components\Section::make('تنظیمات پیشرفته')
                                            ->description('تنظیمات اضافی مخصوص این نوع سوال')
                                            ->collapsible()
                                            ->collapsed()
                                            ->schema([
                                                Forms\Components\KeyValue::make('settings')
                                                    ->label('تنظیمات پیشرفته')
                                                    ->keyLabel('تنظیم')
                                                    ->valueLabel('مقدار')
                                                    ->helperText('تنظیمات اضافی مخصوص این نوع سوال')
                                                    ->addActionLabel('افزودن تنظیم')
                                                    ->reorderable(),
                                            ]),

                                        // راهنما و توضیحات
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Textarea::make('hint')
                                                    ->label('راهنمای سوال')
                                                    ->placeholder('راهنمایی‌هایی که به کاربر کمک می‌کند')
                                                    ->rows(3)
                                                    ->columnSpan(1),

                                                TiptapEditor::make('explanation')
                                                    ->label('توضیح پاسخ')
                                                    ->placeholder('توضیح پاسخ صحیح یا نحوه ارزیابی')
                                                    ->extraInputAttributes(['style' => 'min-height: 8rem;'])
                                                    ->output(TiptapOutput::Html)
                                                    ->columnSpan(1),
                                            ]),
                                    ]),

                                // بخش اضافی برای تنظیمات پیشرفته‌تر
                                Forms\Components\Section::make('تنظیمات پیشرفته سوال')
                                    ->description('محدودیت‌ها، امتیازدهی و اعتبارسنجی')
                                    ->icon('heroicon-o-cog-8-tooth')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('time_limit')
                                                    ->label('محدودیت زمان (ثانیه)')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->suffix('ثانیه')
                                                    ->helperText('زمان مجاز برای پاسخ'),

                                                Forms\Components\TextInput::make('min_value')
                                                    ->label('حداقل مقدار')
                                                    ->numeric()
                                                    ->visible(fn (Get $get): bool => in_array($get('type'), ['number', 'scale'])),

                                                Forms\Components\TextInput::make('max_value')
                                                    ->label('حداکثر مقدار')
                                                    ->numeric()
                                                    ->visible(fn (Get $get): bool => in_array($get('type'), ['number', 'scale'])),
                                            ]),

                                        Forms\Components\TextInput::make('unit')
                                            ->label('واحد')
                                            ->placeholder('مثال: کیلوگرم، سانتی‌متر، سال')
                                            ->visible(fn (Get $get): bool => $get('type') === 'number'),

                                        Forms\Components\Section::make('امتیازدهی و اعتبارسنجی')
                                            ->schema([
                                                Forms\Components\KeyValue::make('scoring_rules')
                                                    ->label('قوانین امتیازدهی')
                                                    ->keyLabel('شرایط')
                                                    ->valueLabel('امتیاز')
                                                    ->addActionLabel('افزودن قانون امتیازدهی')
                                                    ->reorderable(),

                                                Forms\Components\KeyValue::make('validation_rules')
                                                    ->label('قوانین اعتبارسنجی')
                                                    ->keyLabel('قانون')
                                                    ->valueLabel('مقدار')
                                                    ->addActionLabel('افزودن قانون اعتبارسنجی')
                                                    ->reorderable(),
                                            ])
                                            ->columns(1),
                                    ]),
                            ]),

                        // ستون جانبی - 4 ستون
                        Forms\Components\Grid::make(1)
                            ->columnSpan(4)
                            ->schema([
                                // تصویر و رسانه
                                Forms\Components\Section::make('تصویر و رسانه')
                                    ->description('تصاویر و فایل‌های مرتبط با سوال')
                                    ->icon('heroicon-o-photo')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('تصویر سوال')
                                            ->image()
                                            ->directory('questions/images')
                                            ->visibility('private')
                                            ->maxSize(5120) // 5MB
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                            ->imageEditor()
                                            ->imageEditorAspectRatios([
                                                '16:9',
                                                '4:3',
                                                '1:1',
                                            ])
                                            ->helperText('حداکثر حجم: 5 مگابایت | فرمت‌های مجاز: JPG, PNG, GIF, WebP')
                                            ->columnSpanFull(),
                                    ]),

                                // تنظیمات نمایش و رفتار
                                Forms\Components\Section::make('تنظیمات نمایش')
                                    ->description('تنظیمات مربوط به نحوه نمایش و رفتار سوال')
                                    ->icon('heroicon-o-cog-6-tooth')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_required')
                                            ->label('سوال اجباری')
                                            ->helperText('آیا پاسخ دادن به این سوال اجباری است؟')
                                            ->default(true)
                                            ->inline(false)
                                            ->offIcon('heroicon-m-x-mark')
                                            ->onIcon('heroicon-m-check'),

                                        Forms\Components\Toggle::make('is_active')
                                            ->label('وضعیت فعال')
                                            ->helperText('سوال در آزمون نمایش داده شود؟')
                                            ->default(true)
                                            ->inline(false)
                                            ->offIcon('heroicon-m-eye-slash')
                                            ->onIcon('heroicon-m-eye'),

                                        Forms\Components\TextInput::make('sort_order')
                                            ->label('ترتیب نمایش')
                                            ->numeric()
                                            ->default(0)
                                            ->step(1)
                                            ->helperText('عدد کمتر = اولویت بالاتر')
                                            ->suffixIcon('heroicon-m-bars-3-bottom-left'),
                                    ]),

                                // یادداشت مدیر
                                Forms\Components\Section::make('یادداشت‌های مدیریتی')
                                    ->description('یادداشت‌های داخلی برای مدیران سیستم')
                                    ->icon('heroicon-o-clipboard-document-list')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\Textarea::make('admin_note')
                                            ->label('یادداشت مدیر')
                                            ->placeholder('یادداشت‌های داخلی، نکات مهم، یا توضیحات برای سایر مدیران...')
                                            ->rows(4)
                                            ->helperText('این یادداشت فقط برای مدیران سیستم قابل مشاهده است')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    // باقی کدهای table و سایر متدها بدون تغییر باقی می‌مانند...
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('تصویر')
                    ->circular()
                    ->size(45)
                    ->defaultImageUrl(fn () => asset('images/question-placeholder.png')),

                Tables\Columns\TextColumn::make('test.title')
                    ->label('آزمون')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->weight(FontWeight::Medium)
                    ->limit(25)
                    ->tooltip(fn ($record) => $record->test?->title),

                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان سوال')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->weight(FontWeight::Bold)
                    ->tooltip(fn ($record) => $record->title)
                    ->wrap(),

                Tables\Columns\TextColumn::make('type_name')
                    ->label('نوع سوال')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'چند گزینه‌ای چند جوابی' => 'success',
                        'چند گزینه‌ای تک جوابی' => 'info',
                        'صحیح/غلط' => 'warning',
                        'متنی' => 'gray',
                        'عددی' => 'purple',
                        'آپلود فایل' => 'orange',
                        'تاریخ' => 'pink',
                        default => 'secondary',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'چند گزینه‌ای چند جوابی' => 'heroicon-m-check-badge',
                        'چند گزینه‌ای تک جوابی' => 'heroicon-m-radio-button',
                        'صحیح/غلط' => 'heroicon-m-scale',
                        'متنی' => 'heroicon-m-document-text',
                        'عددی' => 'heroicon-m-calculator',
                        'آپلود فایل' => 'heroicon-m-arrow-up-tray',
                        'تاریخ' => 'heroicon-m-calendar-days',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('options_count')
                    ->label('گزینه‌ها')
                    ->alignCenter()
                    ->badge()
                    ->color('gray')
                    ->getStateUsing(fn (Question $record): string =>
                    $record->options && is_array($record->options) ?
                        count($record->options) . ' گزینه' : 'بدون گزینه'
                    ),

                Tables\Columns\IconColumn::make('is_required')
                    ->label('اج��اری')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->falseIcon('heroicon-o-minus-circle')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->tooltip(fn ($record) => $record->is_required ? 'سوال اجباری' : 'سوال اختیاری'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('secondary'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('وضعیت')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->tooltip(fn ($record) => $record->is_active ? 'فعال' : 'غیرفعال'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(fn ($record) => $record->created_at?->diffForHumans()),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین ویرایش')
                    ->dateTime('Y/m/d - H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->tooltip(fn ($record) => $record->updated_at?->diffForHumans()),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('test_id')
                    ->label('آزمون')
                    ->relationship('test', 'title')
                    ->searchable()
                    ->preload()
                    ->indicator('آزمون'),

                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع سوال')
                    ->options(Question::getTypes())
                    ->native(false)
                    ->indicator('نوع'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('وضعیت')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->native(false)
                    ->indicator('وضعیت'),

                Tables\Filters\TernaryFilter::make('is_required')
                    ->label('اجباری بودن')
                    ->trueLabel('اجباری')
                    ->falseLabel('اختیاری')
                    ->native(false)
                    ->indicator('اجباری'),

                Tables\Filters\Filter::make('has_image')
                    ->label('دارای تصویر')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('image'))
                    ->toggle()
                    ->indicator('تصویر'),

                Tables\Filters\Filter::make('has_options')
                    ->label('دارای گزینه')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('options'))
                    ->toggle()
                    ->indicator('گزینه'),

                Tables\Filters\TrashedFilter::make()
                    ->label('حذف شده‌ها')
                    ->indicator('حذف'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('مشاهده')
                        ->icon('heroicon-o-eye')
                        ->color('info'),

                    Tables\Actions\EditAction::make()
                        ->label('ویرایش')
                        ->icon('heroicon-o-pencil')
                        ->color('warning'),

                    Tables\Actions\Action::make('toggle_status')
                        ->label(fn (Question $record) => $record->is_active ? 'غیرفعال کردن' : 'فعال کردن')
                        ->icon(fn (Question $record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                        ->color(fn (Question $record) => $record->is_active ? 'danger' : 'success')
                        ->action(fn (Question $record) => $record->update(['is_active' => !$record->is_active]))
                        ->requiresConfirmation()
                        ->modalDescription('آیا از تغییر وضعیت این سوال اطمینان دارید؟'),

                    Tables\Actions\Action::make('duplicate')
                        ->label('کپی سوال')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('gray')
                        ->action(function (Question $record) {
                            $newRecord = $record->replicate();
                            $newRecord->title = $record->title . ' (کپی)';
                            $newRecord->sort_order = $record->sort_order + 1;
                            $newRecord->save();
                        })
                        ->requiresConfirmation()
                        ->modalDescription('این عمل یک کپی از سوال ایجاد می‌کند'),

                    Tables\Actions\DeleteAction::make()
                        ->label('حذف')
                        ->icon('heroicon-o-trash'),

                    Tables\Actions\RestoreAction::make()
                        ->label('بازگردانی')
                        ->icon('heroicon-o-arrow-path'),

                    Tables\Actions\ForceDeleteAction::make()
                        ->label('حذف کامل')
                        ->icon('heroicon-o-trash'),
                ])
                    ->label('عملیات')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray')
                    ->button(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('فعال کردن همه')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation()
                        ->modalDescription('تمام سوالات انتخاب شده فعال خواهند شد')
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('غیرفعال کردن همه')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation()
                        ->modalDescription('تمام سوالات انتخاب شده غیرفعال خواهند شد')
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('mark_required')
                        ->label('اجباری کردن')
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_required' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('mark_optional')
                        ->label('اختیاری کردن')
                        ->icon('heroicon-o-minus-circle')
                        ->color('gray')
                        ->action(fn ($records) => $records->each->update(['is_required' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف گروهی'),

                    Tables\Actions\RestoreBulkAction::make()
                        ->label('بازگردانی گروهی'),

                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->label('حذف کامل گروهی'),
                ]),
            ])
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->persistSortInSession()
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->extremePaginationLinks()
            ->poll('30s');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
            'view' => Pages\ViewQuestion::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('is_active', true)->count() > 0 ? 'success' : 'gray';
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['test']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'test.title', 'hint'];
    }

    public static function getGlobalSearchResultDetails(\Illuminate\Database\Eloquent\Model $record): array
    {
        return [
            'آزمون' => $record->test?->title,
            'نوع' => $record->type_name,
            'وضعیت' => $record->is_active ? 'فعال' : 'غیرفعال',
        ];
    }

    public static function getGlobalSearchResultTitle(\Illuminate\Database\Eloquent\Model $record): string
    {
        return $record->title;
    }

    public static function getGlobalSearchResultUrl(\Illuminate\Database\Eloquent\Model $record): string
    {
        return static::getUrl('edit', ['record' => $record->getKey()]);
    }
}
