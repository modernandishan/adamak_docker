<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FamiliesRelationManager extends RelationManager
{
    protected static string $relationship = 'families';
    protected static ?string $title = 'خانواده های کاربر';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('عنوان خانواده')
                    ->required(),

                Forms\Components\TextInput::make('father_name')
                    ->label('نام پدر')
                    ->nullable(),

                Forms\Components\TextInput::make('mother_name')
                    ->label('نام مادر')
                    ->nullable(),

                Forms\Components\Toggle::make('is_father_gone')
                    ->label('پدر فوت کرده است؟'),

                Forms\Components\Toggle::make('is_mother_gone')
                    ->label('مادر فوت کرده است؟'),

                Forms\Components\Repeater::make('members')
                    ->label('اعضای خانواده')
                    ->schema([

                        Forms\Components\TextInput::make('role')
                            ->label('نسبت')
                            ->required(),

                        Forms\Components\TextInput::make('age')
                            ->label('سن')
                            ->numeric()
                            ->required()
                            ->nullable(),

                        Forms\Components\Select::make('gender')
                            ->label('جنسیت')
                            ->required()
                            ->options([
                                'male' => 'مرد',
                                'female' => 'زن',
                            ])
                            ->nullable(),
                    ])
                    ->columnSpanFull()
                    ->grid(2)
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان'),

                Tables\Columns\TextColumn::make('father_name')
                    ->label('نام پدر'),

                Tables\Columns\TextColumn::make('mother_name')
                    ->label('نام مادر'),

                Tables\Columns\IconColumn::make('is_father_gone')
                    ->label('پدر')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),

                Tables\Columns\IconColumn::make('is_mother_gone')
                    ->label('مادر')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
