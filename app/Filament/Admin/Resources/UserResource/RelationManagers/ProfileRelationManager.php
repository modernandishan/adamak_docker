<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Models\Profile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProfileRelationManager extends RelationManager
{
    protected static string $relationship = 'profile';
    protected static ?string $title = 'نمایه (پروفایل)';
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return true;
    }
    public function form(Form $form): Form
    {
        return $form
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
                Forms\Components\DatePicker::make('birth')
                    ->label('تاریخ تولد')
                    ->jalali(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('تصویر')
                    ->circular()
                    ->disk('public'),

                Tables\Columns\TextColumn::make('national_code')
                    ->label('کدملی'),

                Tables\Columns\TextColumn::make('province')
                    ->label('استان'),

                Tables\Columns\TextColumn::make('birth')
                    ->label('تاریخ تولد')
                    ->jalaliDate('Y/m/d'),
            ])
            ->filters([])
            ->headerActions([
                //Tables\Actions\CreateAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn (?Model $record) => $record !== null)
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(fn (?Model $record) => $record !== null)
            ])
            ->bulkActions([]);
    }
}
