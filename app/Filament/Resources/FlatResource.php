<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FlatResource\Pages;
use App\Filament\Resources\FlatResource\RelationManagers;
use App\Models\Flat;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlatResource extends Resource
{
    protected static ?string $model = Flat::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('flat_no')->required(),
            Select::make('tower_id')
            ->relationship('tower', 'display_name')
            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->tower_name} ({$record->tower_no})")
            ->searchable()
            ->label('Tower')
            ->preload() // will use till low data for large not recomended
            ->required(),
            TextInput::make('floor')->numeric()->required(),
            TextInput::make('area_sq_ft')->numeric(),
            Select::make('status')
                ->options([
                    'occupied' => 'Occupied',
                    'vacant' => 'Vacant',
                ])
                ->default('occupied')->required(),
            Select::make('resident_id')
                ->relationship(
                    name: 'resident',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->where('role', 'resident')
                )
                ->searchable()
                ->preload() // will use till low data for large not recomended
                ->label('Resident'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('flat_no')->sortable()->searchable(),
                TextColumn::make('tower.display_name'),
                TextColumn::make('floor'),
                TextColumn::make('status')->badge(),
                TextColumn::make('resident.name')->label('Resident'),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'occupied' => 'Occupied',
                    'vacant' => 'Vacant',
                ]),
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
            'index' => Pages\ListFlats::route('/'),
            'create' => Pages\CreateFlat::route('/create'),
            'edit' => Pages\EditFlat::route('/{record}/edit'),
        ];
    }
}
