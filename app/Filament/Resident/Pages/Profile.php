<?php

namespace App\Filament\Resident\Pages;

use Filament\Pages\Page;

use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.resident.pages.profile';

    public ?array $data = [];
    public $user;

    public $editing = false;
    

    public function mount()
    {
        $this->user = auth()->user()->load(['flat.tower', 'familyMembers']);
        $this->form->fill([
            'name'     => $this->user->name,
            'email'    => $this->user->email,
            'phone'    => $this->user->phone,
            'password' => '',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                ->schema([
                    TextInput::make('name')
                    ->label('Full Name')
                    ->required()
                    ->maxLength(255),

                    TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                ]),
                Grid::make(2)
                ->schema([
                    TextInput::make('phone')
                    ->required()
                    ->maxLength(20),

                    TextInput::make('password')
                    ->password()
                    ->label('New Password')
                    ->maxLength(50)
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                    ->required(false),
                ]),
            ])
            ->statePath('data'); 
    }

    public function save()
    {
        $this->user->update(array_filter($this->data));

        $this->form->fill(['password' => '']);

        Notification::make()
        ->title('Profile updated successfully')
        ->success()
        ->send();

        $this->editing = false;
    }
}
