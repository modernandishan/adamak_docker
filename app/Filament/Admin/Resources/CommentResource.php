<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $modelLabel = 'نظر';
    protected static ?string $pluralModelLabel = 'نظرات';
    protected static ?string $navigationLabel = 'نظرات';
    protected static ?string $pluralLabel = 'نظرات';
    protected static ?string $singularLabel = 'نظر';
    protected static ?string $navigationGroup = 'ارسال ها';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('کاربر')
                    ->required(),

                Forms\Components\Select::make('model_type')
                    ->label('نوع مدل')
                    ->options([
                        'App\Models\Product\TradingBot' => 'ربات معامله‌گر',
                        'App\Models\Product\Indicator' => 'اندیکاتور',
                        'App\Models\Platform' => 'پلتفرم',
                        'App\Models\Blog\Post' => 'پست',
                        // مدل‌های اضافی را می‌توانید به این لیست اضافه کنید
                    ])
                    ->required(),

                Forms\Components\TextInput::make('model_id')
                    ->label('شناسه مدل')
                    ->required(),

                Forms\Components\Textarea::make('text')
                    ->label('متن نظر')
                    ->required(),

                Forms\Components\TextInput::make('rating')
                    ->numeric()
                    ->label('امتیاز')
                    ->minValue(1)
                    ->maxValue(5)
                    ->required(),

                Forms\Components\Toggle::make('status')
                    ->label('فعال')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('کاربر')
                    ->searchable(),

                Tables\Columns\TextColumn::make('model_type')
                    ->label('نوع مدل')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'App\Models\Product\TradingBot' => 'ربات معامله‌گر',
                        'App\Models\Product\Indicator' => 'اندیکاتور',
                        default => 'نامشخص',
                    })
                    ->searchable(),

                Tables\Columns\TextColumn::make('text')
                    ->label('متن نظر')
                    ->limit(15),

                Tables\Columns\TextColumn::make('rating')
                    ->label('امتیاز')
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('status')
                    ->label('فعال')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->jalaliDateTime()
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                Filter::make('فعال')
                    ->query(fn (Builder $query) => $query->where('status', true))
                    ->toggle(),

                Filter::make('غیرفعال')
                    ->query(fn (Builder $query) => $query->where('status', false))
                    ->toggle(),

                Filter::make('امتیاز بالا')
                    ->query(fn (Builder $query) => $query->where('rating', '>=', 4)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
