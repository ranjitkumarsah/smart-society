<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Support\Facades\Auth;

class GuardLogin extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        if (! Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
            $this->throwFailureValidationException(); 
        }

        $user = Auth::user();

        if ($user->role !== 'guard') {
            Auth::logout();
            $this->throwFailureValidationException();
        }

        return app(LoginResponse::class);
    }
}
