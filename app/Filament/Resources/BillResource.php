<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Filament\Resources\BillResource\RelationManagers;
use App\Models\Bill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Flat;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;

    protected static ?string $navigationIcon = 'heroicon-o-receipt-percent';
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('flat_id')
            ->label('Flat')
            ->relationship('flat', 'flat_no')
            ->searchable()
            ->preload()
            ->required()
            ->disabled(fn ($record) => $record && $record->status === 'paid'),

            Forms\Components\DatePicker::make('month')
            ->label('Billing Month')
            ->required()
            ->format('Y-m')
            ->displayFormat('F Y')
            ->disabled(fn ($record) => $record && $record->status === 'paid'),

            TextInput::make('amount')
            ->label('Amount (₹)')
            ->required()
            ->numeric()
            ->minValue(0)
            ->disabled(fn ($record) => $record && $record->status === 'paid'),

            Forms\Components\DatePicker::make('due_date')
            ->label('Due Date')
            ->required()
            ->default(now()->addDays(15))
            ->disabled(fn ($record) => $record && $record->status === 'paid'),

            Select::make('status')
            ->required()
            ->options([
                'unpaid' => 'Unpaid',
                'paid' => 'Paid',
                'overdue' => 'Overdue',
            ])
            ->default('unpaid')
            ->disabled(fn ($record) => $record && $record->status === 'paid'),

            TextInput::make('generated_by')
            ->default('manual')
            ->disabled()
            ->visibleOn('view', 'edit'),
        ]);
    }


    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                TextColumn::make('flat.flat_no')->label('Flat'),
                TextColumn::make('month')->label('Month')->date('F Y'),
                TextColumn::make('amount')->money('INR'),
                TextColumn::make('due_date')->label('Due Date')->date(),
                TextColumn::make('status')
                ->badge()
                ->formatStateUsing(fn ($state) => ucfirst($state))
                ->color(fn ($state) => match ($state) {
                    'paid' => 'success',
                    'unpaid' => 'warning',
                    'overdue' => 'danger',
                }),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'unpaid' => 'Unpaid',
                    'paid' => 'Paid',
                    'overdue' => 'Overdue',
                ]),
            ])
           ->actions([
                ...(
                    filament()->getCurrentPanel()->getId() === 'resident'
                        ? []
                        : [Tables\Actions\EditAction::make()]
                ),
            ])
            ->bulkActions([
                ...(
                    filament()->getCurrentPanel()->getId() === 'resident'
                        ? []
                        : [Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                        ])]
                ),
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return filament()->getCurrentPanel()->getId() !== 'resident';
    }

    public static function canEdit(Model $record): bool
    {
        return filament()->getCurrentPanel()->getId() !== 'resident';
    }

    public static function canDelete(Model $record): bool
    {
        return filament()->getCurrentPanel()->getId() !== 'resident';
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (filament()->getCurrentPanel()->getId() === 'resident') {
            $user = auth()->user();

            $query->whereHas('flat', fn ($q) => $q->where('resident_id', $user->id));
        }

        return $query;
    }

}
