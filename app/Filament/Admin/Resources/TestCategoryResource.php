<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestCategoryResource\Pages;
use App\Models\TestCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestCategoryResource extends Resource
{
    protected static ?string $model = TestCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'دسته‌بندی آزمون‌ها';
    protected static ?string $pluralLabel = 'دسته‌بندی آزمون‌ها';
    protected static ?string $label = 'دسته‌بندی آزمون';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->label('اسلاگ')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('توضیحات')
                    ->rows(3)
                    ->nullable(),
                Forms\Components\FileUpload::make('image')
                    ->label('تصویر')
                    ->image()
                    ->directory('test_categories')
                    ->nullable(),
                Forms\Components\Toggle::make('is_active')
                    ->label('فعال')
                    ->inline(false)
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('اسلاگ')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('فعال')
                    ->boolean(),
                Tables\Columns\ImageColumn::make('image')
                    ->label('تصویر')
                    ->size(40),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->dateTime('Y-m-d H:i'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('تاریخ ویرایش')
                    ->dateTime('Y-m-d H:i'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('وضعیت فعال')
                    ->trueLabel('فعال')
                    ->falseLabel('غیرفعال')
                    ->nullableLabel('همه'),
                Tables\Filters\Filter::make('title')
                    ->label('جستجو بر اساس عنوان')
                    ->query(fn (Builder $query, $value) => $query->where('title', 'like', "%{$value}%")),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('ویرایش'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف گروهی'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }

    public static function getRelations(): array
    {
        return [
            // اگر RelationManager برای آزمون‌ها داری اینجا اضافه کن
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestCategories::route('/'),
            'create' => Pages\CreateTestCategory::route('/create'),
            'edit' => Pages\EditTestCategory::route('/{record}/edit'),
        ];
    }
}
