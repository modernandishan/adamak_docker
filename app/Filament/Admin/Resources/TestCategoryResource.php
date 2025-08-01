<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestCategoryResource\Pages;
use App\Models\TestCategory;
use Filament\Forms;
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

class TestCategoryResource extends Resource
{
    protected static ?string $model = TestCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'دسته‌بندی آزمون‌ها';
    protected static ?string $pluralLabel = 'دسته‌بندی آزمون‌ها';
    protected static ?string $label = 'دسته‌بندی آزمون';
    protected static ?string $navigationGroup = 'مدیریت آزمون‌ها';
    protected static ?int $navigationSort = 1;

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
                                                Forms\Components\TextInput::make('title')
                                                    ->label('عنوان')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                                Forms\Components\TextInput::make('slug')
                                                    ->label('اسلاگ')
                                                    ->required()
                                                    ->unique(TestCategory::class, 'slug', ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->rules(['regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'])
                                                    ->helperText('فقط حروف انگلیسی کوچک، اعداد و خط تیره مجاز است'),
                                            ]),
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Toggle::make('is_active')
                                                    ->label('فعال')
                                                    ->inline(false)
                                                    ->default(true),
                                                Forms\Components\TextInput::make('sort_order')
                                                    ->label('ترتیب نمایش')
                                                    ->numeric()
                                                    ->default(0)
                                                    ->helperText('عدد کمتر اولویت بالاتر دارد'),
                                            ]),
                                        TiptapEditor::make('description')
                                            ->label('توضیحات (کامل)')
                                            ->extraInputAttributes(['style' => 'min-height: 32rem;'])
                                            ->output(TiptapOutput::Html)
                                            ->columnSpanFull(),
                                    ]),
                            ])
                            ->columnSpan(4),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Section::make('تصویر دسته‌بندی')
                                    ->schema([
                                        Forms\Components\FileUpload::make('image')
                                            ->label('تصویر شاخص')
                                            ->optimize('webp')
                                            ->directory('test_categories')
                                            ->uploadingMessage('در حال آپلود...')
                                            ->image()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/svg+xml'])
                                            ->maxSize(16384)
                                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                                            ->helperText('حداکثر سایز: 16 مگابایت'),
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
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable()
                    ->fontFamily('mono')
                    ->color('gray'),
                Tables\Columns\TextColumn::make('tests_count')
                    ->label('تعداد آزمون‌ها')
                    ->counts('tests')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('active_tests_count')
                    ->label('آزمون‌های فعال')
                    ->counts('activeTests')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),
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
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y/m/d H:i')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('آخرین ویرایش')
                    ->dateTime('Y/m/d H:i')
                    ->jalaliDate()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('وضعیت')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->native(false),

                Tables\Filters\Filter::make('has_tests')
                    ->label('دارای آزمون')
                    ->query(fn (Builder $query): Builder => $query->has('tests'))
                    ->toggle(),

                Tables\Filters\Filter::make('tests_count')
                    ->label('تعداد آزمون‌ها')
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('tests_from')
                                    ->label('از')
                                    ->numeric()
                                    ->placeholder('مثال: 1'),
                                Forms\Components\TextInput::make('tests_to')
                                    ->label('تا')
                                    ->numeric()
                                    ->placeholder('مثال: 10'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tests_from'],
                                fn (Builder $query, $value): Builder => $query->withCount('tests')->having('tests_count', '>=', $value),
                            )
                            ->when(
                                $data['tests_to'],
                                fn (Builder $query, $value): Builder => $query->withCount('tests')->having('tests_count', '<=', $value),
                            );
                    }),

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
                        ->label(fn (TestCategory $record) => $record->is_active ? 'غیرفعال کردن' : 'فعال کردن')
                        ->icon(fn (TestCategory $record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                        ->color(fn (TestCategory $record) => $record->is_active ? 'warning' : 'success')
                        ->action(fn (TestCategory $record) => $record->update(['is_active' => !$record->is_active]))
                        ->requiresConfirmation(),
                    Tables\Actions\Action::make('duplicate')
                        ->label('کپی')
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->action(function (TestCategory $record) {
                            $newRecord = $record->replicate();
                            $newRecord->title = $record->title . ' (کپی)';
                            $newRecord->slug = $record->slug . '-copy-' . time();
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
            'index' => Pages\ListTestCategories::route('/'),
            'create' => Pages\CreateTestCategory::route('/create'),
            'edit' => Pages\EditTestCategory::route('/{record}/edit'),
            'view' => Pages\ViewTestCategory::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'primary';
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'description'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'آزمون‌ها' => $record->tests_count . ' آزمون',
            'وضعیت' => $record->is_active ? 'فعال' : 'غیرفعال',
        ];
    }
}
