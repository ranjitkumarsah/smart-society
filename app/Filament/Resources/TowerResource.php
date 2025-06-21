<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TowerResource\Pages;
use App\Filament\Resources\TowerResource\RelationManagers;
use App\Models\Tower;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TowerResource extends Resource
{
    protected static ?string $model = Tower::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('tower_no')
                    ->required()
                    ->maxLength(10),
                TextInput::make('tower_name')
                    ->required()
                    ->maxLength(50),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tower_no')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tower_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Created On')
                    ->dateTime('d M Y, h:i A'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTowers::route('/'),
            'create' => Pages\CreateTower::route('/create'),
            'edit' => Pages\EditTower::route('/{record}/edit'),
        ];
    }
}
