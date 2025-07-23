<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestResource\Pages;
use App\Models\Test;
use App\Models\TestCategory;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use FilamentTiptapEditor\Enums\TiptapOutput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Set;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'آزمون‌ها';
    protected static ?string $pluralLabel = 'آزمون‌ها';
    protected static ?string $label = 'آزمون';
    protected static ?string $navigationGroup = 'مدیریت آزمون‌ها';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(6)
                    ->schema([
                        Forms\Components\Grid::make(4)
                            ->schema([
                                Forms\Components\Section::make('اطلاعات اصلی')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Select::make('test_category_id')
                                                    ->label('دسته‌بندی')
                                                    ->relationship('category', 'title')
                                                    ->searchable()
                                                    ->preload()
                                                    ->required()
                                                    ->createOptionForm([
                                                        Forms\Components\TextInput::make('title')
                                                            ->label('عنوان')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('slug')
                                                            ->label('اسلاگ')
                                                            ->required(),
                                                    ]),
                                                Forms\Components\Select::make('status')
                                                    ->label('وضعیت')
                                                    ->options([
                                                        'Draft' => 'پیش‌نویس',
                                                        'Published' => 'منتشر شده',
                                                        'Archived' => 'بایگانی شده',
                                                    ])
                                                    ->default('Draft')
                                                    ->required()
                                                    ->native(false),
                                            ]),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('عنوان آزمون')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')
                                                    ->label('اسلاگ')
                                                    ->required()
                                                    ->unique(Test::class, 'slug', ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'])
                                                    ->helperText('فقط حروف انگلیسی کوچک، اعداد و خط تیره مجاز است'),
                                            ]),
                                        TiptapEditor::make('description')
                                            ->label('توضیحات (کامل)')
                                            ->extraInputAttributes(['style' => 'min-height: 32rem;'])
                                            ->output(TiptapOutput::Html)
                                            ->required()
                                            ->columnSpanFull(),
                                    ]),

                                Forms\Components\Section::make('تنظیمات قیمت و زمان')
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('price')
                                                    ->label('قیمت (ریال)')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('💰')
                                                    ->minValue(0)
                                                    ->step(1000),
                                                Forms\Components\TextInput::make('sale')
                                                    ->label('قیمت با تخفیف (ریال)')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->prefix('🏷️')
                                                    ->minValue(0)
                                                    ->step(1000),
                                                Forms\Components\TextInput::make('required_minutes')
                                                    ->label('زمان مورد نیاز (دقیقه)')
                                                    ->numeric()
                                                    ->default(30)
                                                    ->minValue(1)
                                                    ->suffix('دقیقه')
                                                    ->helperText('زمان تقریبی برای تکمیل آزمون'),
                                            ]),
                                    ]),

                                Forms\Components\Section::make('محدودیت‌های سنی')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\TextInput::make('min_age')
                                                    ->label('حداقل سن')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->minValue(0)
                                                    ->maxValue(100)
                                                    ->suffix('سال'),
                                                Forms\Components\TextInput::make('max_age')
                                                    ->label('حداکثر سن')
                                                    ->numeric()
                                                    ->default(100)
                                                    ->minValue(0)
                                                    ->maxValue(120)
                                                    ->suffix('سال'),
                                            ]),
                                    ]),
                            ])
                            ->columnSpan(4),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Section::make('تصویر آزمون')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('تصویر شاخص')
                                            ->optimize('webp')
                                            ->directory('tests')
                                            ->uploadingMessage('در حال آپلود...')
                                            ->image()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/svg+xml'])
                                            ->maxSize(16384)
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->helperText('حداکثر سایز: 16 مگابایت'),
                                    ]),

                                Forms\Components\Section::make('تنظیمات پیشرفته')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_need_family')
                                            ->label('نیاز به اطلاعات خانواده')
                                            ->helperText('آیا برای این آزمون اطلاعات خانواده لازم است؟')
                                            ->inline(false),
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('فعال')
                                            ->default(true)
                                            ->inline(false),
                                        Forms\Components\TextInput::make('sort_order')
                                            ->label('ترتیب نمایش')
                                            ->numeric()
                                            ->default(0)
                                            ->helperText('عدد کمتر اولویت بالاتر دارد'),
                                        Forms\Components\TextInput::make('type')
                                            ->label('نوع آزمون')
                                            ->maxLength(255)
                                            ->placeholder('مثال: شخصیت‌شناسی، هوش، ...')
                                            ->helperText('دسته‌بندی نوع آزمون'),
                                        /*Forms\Components\TextInput::make('catalog')
                                            ->label('کاتالوگ')
                                            ->maxLength(255)
                                            ->placeholder('کد یا شناسه کاتالوگ')
                                            ->helperText('شناسه یا کد کاتالوگ آزمون'),*/
                                        FileUpload::make('catalog')
                                            ->label('کاتالوگ')
                                            ->directory('test-catalog'),
                                        Forms\Components\Textarea::make('admin_note')
                                            ->label('یادداشت مدیر')
                                            ->rows(3)
                                            ->placeholder('یادداشت‌های داخلی برای مدیران...')
                                            ->helperText('این یادداشت فقط برای مدیران قابل مشاهده است'),
                                    ]),

                                Forms\Components\Section::make('اطلاعات متا و سئو')
                                    ->schema([
                                        Forms\Components\Section::make('اطلاعات سئو پایه')
                                            ->schema([
                                                Forms\Components\TextInput::make('seoMeta.title')
                                                    ->label('عنوان سئو')
                                                    ->maxLength(60)
                                                    ->helperText('حداکثر 60 کاراکتر'),
                                                Forms\Components\Textarea::make('seoMeta.description')
                                                    ->label('توضیحات سئو')
                                                    ->maxLength(160)
                                                    ->rows(3)
                                                    ->helperText('حداکثر 160 کاراکتر'),
                                                Forms\Components\FileUpload::make('seoMeta.image')
                                                    ->label('تصویر سئو')
                                                    ->optimize('webp')
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                                    ->maxSize(16384),
                                                Forms\Components\TextInput::make('seoMeta.author')
                                                    ->label('نویسنده'),
                                                Forms\Components\TextInput::make('seoMeta.robots')
                                                    ->label('دستورات Robots')
                                                    ->placeholder('index,follow'),
                                                Forms\Components\TextInput::make('seoMeta.canonical_url')
                                                    ->label('لینک Canonical')
                                                    ->url(),
                                                Forms\Components\TagsInput::make('seoMeta.keywords')
                                                    ->label('کلمات کلیدی'),
                                            ]),

                                        Forms\Components\Section::make('سئو شبکه‌های اجتماعی')
                                            ->schema([
                                                Forms\Components\TextInput::make('seoMeta.facebook_title')
                                                    ->label('عنوان فیسبوک'),
                                                Forms\Components\Textarea::make('seoMeta.facebook_description')
                                                    ->label('توضیحات فیسبوک')
                                                    ->rows(2),
                                                Forms\Components\FileUpload::make('seoMeta.facebook_image')
                                                    ->label('تصویر فیسبوک')
                                                    ->optimize('webp')
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                                    ->maxSize(16384),
                                                Forms\Components\TextInput::make('seoMeta.twitter_title')
                                                    ->label('عنوان توییتر'),
                                                Forms\Components\Textarea::make('seoMeta.twitter_description')
                                                    ->label('توضیحات توییتر')
                                                    ->rows(2),
                                                Forms\Components\FileUpload::make('seoMeta.twitter_image')
                                                    ->label('تصویر توییتر')
                                                    ->optimize('webp')
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                                    ->maxSize(16384),
                                                Forms\Components\TextInput::make('seoMeta.open_graph_title')
                                                    ->label('عنوان Open Graph'),
                                                Forms\Components\Textarea::make('seoMeta.open_graph_description')
                                                    ->label('توضیحات Open Graph')
                                                    ->rows(2),
                                                Forms\Components\FileUpload::make('seoMeta.open_graph_image')
                                                    ->label('تصویر Open Graph')
                                                    ->optimize('webp')
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                                    ->maxSize(16384),
                                            ])
                                            ->collapsible()
                                            ->collapsed(),

                                        Forms\Components\Section::make('داده‌های ساختاریافته')
                                            ->schema([
                                                Forms\Components\TextInput::make('seoMeta.schema_type')
                                                    ->label('نوع Schema')
                                                    ->placeholder('Product, Article, etc.'),
                                                Forms\Components\Textarea::make('seoMeta.schema_data')
                                                    ->label('داده‌های Schema')
                                                    ->rows(4)
                                                    ->helperText('JSON format'),
                                            ])
                                            ->collapsible()
                                            ->collapsed(),

                                        Forms\Components\Section::make('تنظیمات پیشرفته سئو')
                                            ->schema([
                                                Forms\Components\TextInput::make('seoMeta.priority')
                                                    ->label('اولویت')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(1)
                                                    ->step(0.1),
                                                Forms\Components\Toggle::make('seoMeta.sitemap_include')
                                                    ->label('نمایش در نقشه سایت')
                                                    ->default(true),
                                                Forms\Components\TextInput::make('seoMeta.sitemap_priority')
                                                    ->label('اولویت نقشه سایت')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(1)
                                                    ->step(0.1),
                                                Forms\Components\Select::make('seoMeta.sitemap_changefreq')
                                                    ->label('فرکانس تغییر')
                                                    ->options([
                                                        'always' => 'همیشه',
                                                        'hourly' => 'ساعتی',
                                                        'daily' => 'روزانه',
                                                        'weekly' => 'هفتگی',
                                                        'monthly' => 'ماهانه',
                                                        'yearly' => 'سالانه',
                                                        'never' => 'هرگز',
                                                    ])
                                                    ->native(false),
                                            ])
                                            ->collapsible()
                                            ->collapsed(),
                                    ]),
                            ])
                            ->columnSpan(2),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('تصویر')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/placeholder.png')),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(30),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('دسته‌بندی')
                    ->sortable()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('status')
                    ->label('وضعیت')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft' => 'warning',
                        'Published' => 'success',
                        'Archived' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'Draft' => 'پیش‌نویس',
                        'Published' => 'منتشر شده',
                        'Archived' => 'بایگانی شده',
                    }),
                MoneyColumn::make('price')
                    ->label('قیمت')
                    ->money('IRR')
                    ->sortable()
                    ->alignEnd(),
                MoneyColumn::make('sale')
                    ->label('قیمت نهایی')
                    //->getStateUsing(fn (Test $record): int => $record->final_price)
                    ->money('IRR')
                    ->sortable()
                    ->alignEnd()
                    ->color(fn (Test $record): string => $record->is_free ? 'success' : 'primary'),
                Tables\Columns\TextColumn::make('required_minutes')
                    ->label('زمان')
                    ->formatStateUsing(fn (Test $record): string => $record->required_time)
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('age_range')
                    ->label('رده سنی')
                    ->getStateUsing(fn (Test $record): string => $record->age_range)
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_need_family')
                    ->label('نیاز خانواده')
                    ->boolean()
                    ->trueIcon('heroicon-o-users')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('info')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('ترتیب')
                    ->sortable()
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('وضعیت')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('questions_count')
                    ->label('تعداد سوال')
                    ->counts('questions')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('active_questions_count')
                    ->label('سوالات فعال')
                    ->counts('activeQuestions')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('test_category_id')
                    ->label('دسته‌بندی')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'Draft' => 'پیش‌نویس',
                        'Published' => 'منتشر شده',
                        'Archived' => 'بایگانی شده',
                    ])
                    ->native(false),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('فعال/غیرفعال')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->native(false),

                Tables\Filters\TernaryFilter::make('is_need_family')
                    ->label('نیاز به خانواده')
                    ->trueLabel('نیاز دارد')
                    ->falseLabel('نیاز ندارد')
                    ->native(false),

                Tables\Filters\Filter::make('price_range')
                    ->label('محدوده قیمت')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('price_from')
                                    ->label('از')
                                    ->numeric()
                                    ->placeholder('0'),
                                Forms\Components\TextInput::make('price_to')
                                    ->label('تا')
                                    ->numeric()
                                    ->placeholder('1000000'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['price_from'],
                                fn (Builder $query, $value): Builder => $query->where('price', '>=', $value),
                            )
                            ->when(
                                $data['price_to'],
                                fn (Builder $query, $value): Builder => $query->where('price', '<=', $value),
                            );
                    }),

                Tables\Filters\Filter::make('free_tests')
                    ->label('آزمون‌های رایگان')
                    ->query(fn (Builder $query): Builder => $query->where('price', 0))
                    ->toggle(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع آزمون')
                    ->options(function () {
                        return Test::whereNotNull('type')
                            ->distinct()
                            ->pluck('type', 'type')
                            ->toArray();
                    })
                    ->searchable(),

                Tables\Filters\TrashedFilter::make()
                    ->label('وضعیت حذف'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('مشاهده')
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->label('ویرایش')
                        ->icon('heroicon-o-pencil'),
                    Tables\Actions\Action::make('toggle_status')
                        ->label(fn (Test $record) => $record->is_active ? 'غیرفعال کردن' : 'فعال کردن')
                        ->icon(fn (Test $record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                        ->color(fn (Test $record) => $record->is_active ? 'warning' : 'success')
                        ->action(fn (Test $record) => $record->update(['is_active' => !$record->is_active]))
                        ->requiresConfirmation(),
                    Tables\Actions\Action::make('duplicate')
                        ->label('کپی')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->action(function (Test $record) {
                            $newRecord = $record->replicate();
                            $newRecord->title = $record->title . ' (کپی)';
                            $newRecord->slug = $record->slug . '-copy-' . time();
                            $newRecord->status = 'Draft';
                            $newRecord->save();
                        })
                        ->requiresConfirmation(),
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
                        ->label('فعال کردن')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('غیرفعال کردن')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('publish')
                        ->label('انتشار')
                        ->icon('heroicon-o-globe-alt')
                        ->color('success')
                        ->action(fn ($records) => $records->each->update(['status' => 'Published']))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('archive')
                        ->label('بایگانی')
                        ->icon('heroicon-o-archive-box')
                        ->color('warning')
                        ->action(fn ($records) => $records->each->update(['status' => 'Archived']))
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
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->persistSortInSession()
            ->striped()
            ->paginated([10, 25, 50, 100]);
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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
            'view' => Pages\ViewTest::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'success';
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['category']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description', 'category.title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'دسته‌بندی' => $record->category?->title,
            'وضعیت' => match($record->status) {
                'Draft' => 'پیش‌نویس',
                'Published' => 'منتشر شده',
                'Archived' => 'بایگانی شده',
            },
        ];
    }
}
