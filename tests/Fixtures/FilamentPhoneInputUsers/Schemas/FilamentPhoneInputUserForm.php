<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class FilamentPhoneInputUserForm
{
    public static $resource = FilamentPhoneInputUserResource::class;

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->autofocus()
                    ->placeholder('Enter a name...')
                    ->helperText('This is the name of the user.'),

                TextInput::make('email')
                    ->required()
                    ->placeholder('Enter an email address...')
                    ->helperText('This is the email address of the user.'),

                TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state))
                    ->afterStateHydrated(fn ($component) => $component->state(null))
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),

                self::$resource::getPhoneInput(),
            ]);
    }
}
