<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardResource\Pages;
use App\Filament\Resources\GuardResource\RelationManagers;
use App\Models\User as Guard;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class GuardResource extends Resource
{
    protected static ?string $model = Guard::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $modelLabel = 'Guard';         
    protected static ?string $pluralModelLabel = 'Guards';      
    protected static ?string $navigationLabel = 'Guards';       
    protected static ?string $slug = 'guards';  

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),

                TextInput::make('email')
                ->email()->maxLength(191)
                ->required()->unique(ignoreRecord: true),

                TextInput::make('phone')
                ->tel()->maxLength(191)
                ->required()->unique(ignoreRecord: true),

                TextInput::make('password')
                ->password()
                ->required(fn ($livewire) => $livewire instanceof Pages\CreateGuardUser)
                ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                ->label('Password'),
                Forms\Components\Hidden::make('role')->default('guard')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('email')->sortable()->searchable(),
                TextColumn::make('phone')->sortable()->searchable(),
                TextColumn::make('created_at')->dateTime('d M Y, h:i A'),
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

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('role', 'guard');
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
            'index' => Pages\ListGuards::route('/'),
            'create' => Pages\CreateGuard::route('/create'),
            'edit' => Pages\EditGuard::route('/{record}/edit'),
        ];
    }
}
