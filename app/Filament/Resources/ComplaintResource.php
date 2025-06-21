<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComplaintResource\Pages;
use App\Filament\Resources\ComplaintResource\RelationManagers;
use App\Models\Complaint;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Hidden;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-circle';

    public static function form(Form $form): Form
    {
        $user = auth()->user();
        $panel = filament()->getCurrentPanel()->getId();

        return $form
            ->schema([
                TextInput::make('title')->required()->maxLength(255),

                Textarea::make('description')->required()->maxLength(1000),

                Select::make('resident_id')
                ->label('Resident')
                ->required()
                ->relationship(
                    name: 'resident',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->where('role', 'resident')
                )
                ->preload()
                ->searchable()
                ->default($user->id)
                ->disabled($panel === 'resident')
                ->visible($panel === 'admin'),

                // Only admin can assign staff
                Select::make('assigned_to')
                ->label('Assign to Staff')
                ->relationship(
                    name: 'staff',
                    titleAttribute: 'name',
                    modifyQueryUsing: fn ($query) => $query->where('role', 'staff')
                )
                ->preload()
                ->searchable()
                ->visible($panel === 'admin'),
                
                Select::make('status')
                ->options([
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'closed' => 'Closed',
                ])
                ->default('open')
                ->disabled(),

                Hidden::make('resident_id')
                ->default(fn () => auth()->id())
                ->dehydrated(true)
                ->required()
                ->visible(filament()->getCurrentPanel()->getId() === 'resident')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable(),
                TextColumn::make('resident.name')->label('Resident'),
                TextColumn::make('staff.name')->label('Assigned Staff'),
                TextColumn::make('status')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'open' => 'warning',
                    'in_progress' => 'info',
                    'closed' => 'success',
                }),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                ->visible(fn (Model $record) =>
                    filament()->getCurrentPanel()->getId() === 'admin' ||
                    ($record->status === 'open' && $record->resident_id === auth()->id())
                ),
            ])
           ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                ->visible(fn () => filament()->getCurrentPanel()->getId() === 'admin')
                ->before(function ($records) {
                    foreach ($records as $record) {
                        if ($record->status === 'in_progress') {
                            \Filament\Notifications\Notification::make()
                                ->title('Deletion Blocked')
                                ->body("Complaint ID {$record->id} is in progress and cannot be deleted.")
                                ->danger()
                                ->send();

                            // Abort without throwing the Notification object
                            abort(403, "Some complaints can't be deleted.");
                        }
                    }
                }),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (filament()->getCurrentPanel()->getId() === 'resident') {
            $query->where('resident_id', auth()->id());
        }

        return $query;
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        $panel = filament()->getCurrentPanel()->getId();
        return $panel === 'admin'
            ? $record->status === 'open'
            : $record->status === 'open' && $record->resident_id === auth()->id();
    }

    public static function canEdit(Model $record): bool
    {
        $panel = filament()->getCurrentPanel()->getId();
        return $panel === 'admin'
            ? $record->status === 'open'
            : $record->status === 'open' && $record->resident_id === auth()->id();
    }
}
