<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FilamentPhoneInputUser extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $table = 'users';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
