<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class WalletRelationManager extends RelationManager
{
    protected static string $relationship = 'wallet';
    protected static ?string $title = 'کیف پول';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('balance')
                    ->label('موجودی')
                    ->numeric()
                    ->prefix('تومان')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                MoneyColumn::make('balance')
                    ->label('موجودی')
                    ->money('IRR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاریخ ایجاد')
                    ->jalaliDate(),
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
