<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Auth\Authenticatable;

class Login extends BaseLogin
{
    protected function isUserAllowedToAccessPanel(Authenticatable $user): bool
    {
        if (! parent::isUserAllowedToAccessPanel($user)) {
            abort(403, 'Access Denied. Only Texmart administrators can access this dashboard.');
        }

        return true;
    }
}