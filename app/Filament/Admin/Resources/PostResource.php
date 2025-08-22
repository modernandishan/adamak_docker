<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PostResource\Pages;
//use App\Filament\Admin\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms\Components\DatePicker;
use FilamentTiptapEditor\Extensions\Extensions\StyleExtension;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\Enums\TiptapOutput;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static ?string $modelLabel = 'پست';
    protected static ?string $pluralModelLabel = 'پست‌ها';
    protected static ?string $navigationGroup = 'وبلاگ';
    protected static ?string $pluralLabel = 'پست‌ها';
    protected static ?string $singularLabel = 'پست';
    protected static ?string $navigationLabel = 'پست‌ها';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(6)
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Section::make('محتوای اصلی')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('title')
                                                    ->label('عنوان')
                                                    ->placeholder('عنوان استراتژی')
                                                    ->required(),
                                                TextInput::make('slug')
                                                    ->label('نامک')
                                                    ->placeholder('آدرس نمایشی (انگلیسی و فاصله‌ها با -)')
                                                    ->unique(ignoreRecord: true)
                                                    ->required(),
                                                Select::make('category_id')
                                                    ->label('دسته بندی')
                                                    ->relationship('category', 'title')
                                                    ->required()
                                                    ->searchable(),
                                            ]),
                                        TagsInput::make('tags')
                                            ->label('برچسب ها')
                                            ->nullable(),
                                        Textarea::make('excerpt')
                                            ->label('خلاصه خیلی کوتاه')
                                            ->required(),
                                        TiptapEditor::make('content')
                                            ->gridLayouts([
                                                'two-columns',
                                                'three-columns',
                                                'four-columns',
                                                'five-columns',
                                                'fixed-two-columns',
                                                'fixed-three-columns',
                                                'fixed-four-columns',
                                                'fixed-five-columns',
                                                'asymmetric-left-thirds',
                                                'asymmetric-right-thirds',
                                                'asymmetric-left-fourths',
                                                'asymmetric-right-fourths',
                                            ])
                                            ->label('توضیحات (کامل)')
                                            ->extraInputAttributes(['style' => 'min-height: 64rem;'])
                                            ->output(TiptapOutput::Html)
                                            ->required(),
                                        Forms\Components\Repeater::make('galleries')
                                            ->label('گالری‌ها')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('عنوان گالری'),
                                                Forms\Components\Repeater::make('items')
                                                    ->label('تصاویر گالری')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('name')
                                                            ->label('نام تصویر'),
                                                        Forms\Components\FileUpload::make('image')
                                                            ->optimize('webp')
                                                            ->label('آپلود تصویر')
                                                            ->directory('blog/post')
                                                            ->image()
                                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/png'])
                                                            ->maxSize(16384)
                                                            ->required(),
                                                    ])
                                                    ->collapsible()
                                                    ->itemLabel('نام تصویر')
                                            ])
                                            ->collapsible()
                                            ->itemLabel('عنوان گالری')
                                            ->default([]), // 👈 مقدار پیش‌فرض خالی قرار داده شد
                                    ]),
                            ])
                            ->columnSpan(4),
                        Grid::make(2)
                            ->schema([
                                Section::make('نمای پست')
                                    ->schema([
                                        FileUpload::make('thumbnail')
                                            ->optimize('webp')
                                            ->label('تصویر شاخص (ابعاد مربعی)')
                                            ->uploadingMessage('در حال آپلود...')
                                            ->required()
                                            ->directory('blog/post')
                                            ->image()
                                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/png'])
                                            ->maxSize(16384)
                                            ->imageEditorAspectRatios([
                                                '1:1',
                                            ]),
                                    ]),
                                Section::make('پیشرفته')
                                    ->schema([
                                        Select::make('user_id')
                                            ->label('نویسنده محتوا')
                                            ->placeholder('یک کاربر را انتخاب کنید')
                                            ->relationship('author', 'name')
                                            ->options(function () {
                                                return \App\Models\User::query()
                                                    ->whereHas('roles', function ($query) {
                                                        $query->whereIn('name', ['admin', 'super_admin', 'vendor']);
                                                    })
                                                    ->pluck('name', 'id');
                                            })
                                            ->default(Auth::id())
                                            ->searchable()
                                            ->preload()
                                            ->required(),
                                        DatePicker::make('published_at')
                                            ->jalali(),
                                        Select::make('status')
                                            ->options([
                                                'draft' => 'پیش نویس',
                                                'published' => 'منتشر شده',
                                                'archived' => 'آرشیو شده',
                                            ])
                                            ->default('published')
                                            ->label('نوع محصول')
                                            ->required(),
                                        Toggle::make('is_active')
                                            ->label('فعال بودن')
                                            ->default(true),
                                        TextInput::make('youtube_link')
                                            ->label('لینک یوتیوب')
                                            ->nullable()
                                            ->url(),
                                        TextInput::make('aparat_link')
                                            ->label('لینک آپارات')
                                            ->nullable()
                                            ->url(),
                                        Repeater::make('related_links')
                                            ->label('لینک های مرتبط')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('title')
                                                            ->label('عنوان')
                                                            ->required(),
                                                        TextInput::make('url')
                                                            ->url()
                                                            ->label('نشانی')
                                                            ->required(),
                                                    ]),
                                            ])
                                            ->minItems(0)
                                            ->maxItems(50)
                                            ->default([]),
                                    ]),
                                Section::make('اطلاعات متا')
                                    ->schema([
                                        Fieldset::make('اطلاعات سئو')
                                            ->schema([
                                                TextInput::make('seo.title')->label('عنوان')->nullable(),
                                                Textarea::make('seo.description')->label('توضیحات')->nullable(),
                                                FileUpload::make('seo.image')
                                                    ->optimize('webp')
                                                    ->label('تصویر')
                                                    ->nullable()
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                                                    ->maxSize(16384),
                                                TextInput::make('seo.author')->label('نویسنده')->nullable(),
                                                TextInput::make('seo.robots')->label('دستورات Robots')->nullable(),
                                                TextInput::make('seo.canonical_url')->label('لینک Canonical')->nullable(),
                                                TagsInput::make('seo.keywords')->label('کلمات کلیدی')->nullable(),
                                            ])->columns(1),
                                        Fieldset::make('سئو شبکه‌های اجتماعی')
                                            ->schema([
                                                TextInput::make('seo.facebook_title')->label('عنوان فیسبوک')->nullable(),
                                                Textarea::make('seo.facebook_description')->label('توضیحات فیسبوک')->nullable(),
                                                FileUpload::make('seo.facebook_image')->label('تصویر فیسبوک')
                                                    ->optimize('webp')
                                                    ->nullable()
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/png'])
                                                    ->maxSize(16384),
                                                TextInput::make('seo.twitter_title')->label('عنوان توییتر')->nullable(),
                                                Textarea::make('seo.twitter_description')->label('توضیحات توییتر')->nullable(),
                                                FileUpload::make('seo.twitter_image')->label('تصویر توییتر')
                                                    ->optimize('webp')
                                                    ->nullable()
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/jpg', 'image/png'])
                                                    ->maxSize(16384),
                                                TextInput::make('seo.open_graph_title')->label('عنوان Open Graph')->nullable(),
                                                Textarea::make('seo.open_graph_description')->label('توضیحات Open Graph')->nullable(),
                                                FileUpload::make('seo.open_graph_image')->label('تصویر Open Graph')
                                                    ->optimize('webp')
                                                    ->nullable()
                                                    ->directory('seo-meta')
                                                    ->image()
                                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/jpg', 'image/png', 'image/svg+xml']) // فرمت‌های مجاز
                                                    ->maxSize(16384),
                                            ])->columns(1),
                                        Fieldset::make('داده‌های ساختاریافته')
                                            ->schema([
                                                TextInput::make('seo.schema_type')->label('نوع Schema')->nullable(),
                                                Textarea::make('seo.schema_data')->label('داده‌های Schema')->nullable(),
                                            ])->columns(1),
                                        Fieldset::make('اطلاعات پیشرفته')
                                            ->schema([
                                                TextInput::make('seo.priority')->label('اولویت')->nullable(),
                                                Toggle::make('seo.sitemap_include')->label('نمایش در نقشه سایت')->default(true),
                                                TextInput::make('seo.sitemap_priority')->label('اولویت نقشه سایت')->nullable(),
                                                TextInput::make('seo.sitemap_changefreq')->label('فرکانس تغییر نقشه سایت')->nullable(),
                                            ])->columns(1),
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
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('تصویر شاخص')
                    ->circular()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category.title')
                    ->label('دسته‌بندی')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('فعال'),
                Tables\Columns\TextColumn::make('author.name')
                    ->label('نویسنده')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('زمان انتشار')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('وضعیت')
                    ->options([
                        'draft' => 'پیش نویس',
                        'published' => 'منتشر شده',
                        'archived' => 'آرشیو شده',
                    ]),
                Tables\Filters\TrashedFilter::make()
                    ->label('حذف شده‌ها'),
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('دسته‌بندی')
                    ->relationship('category', 'title'),
                Tables\Filters\Filter::make('published_at')
                    ->label('زمان انتشار')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('از تاریخ')->jalali(),
                        Forms\Components\DatePicker::make('to')->label('تا تاریخ')->jalali(),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('published_at', '>=', $data['from']))
                            ->when($data['to'], fn($q) => $q->whereDate('published_at', '<=', $data['to']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class])
            ->orderByRaw('COALESCE(published_at, created_at) DESC');
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('is_active', true)->whereNull('deleted_at')->count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
