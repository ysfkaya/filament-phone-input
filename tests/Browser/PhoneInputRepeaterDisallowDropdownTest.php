<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputRepeaterDisallowDropdownTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputRepeaterDisallowDropdownResource::class;

    #[Test]
    public function it_saves_phone_number_in_repeater_when_dropdown_is_disallowed(): void
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('input[type="tel"]')
                ->type('#form\\.name', 'John Doe')
                ->type('#form\\.password', 'password')
                ->type('#form\\.email', fake()->unique()->safeEmail())
                ->pause(300)
                ->typeSlowly('input[type="tel"]', '+971501234567')
                ->pause(500)
                ->press('Create')
                ->pause(1000)
        );

        $this->assertDatabaseHas('filament_phone_input_contacts', [
            'phone' => '+971501234567',
        ]);
    }
}

class PhoneInputRepeaterDisallowDropdownResource extends FilamentPhoneInputUserResource
{
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->autofocus(),

            TextInput::make('email')
                ->required(),

            TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255)
                ->dehydrated(fn ($state): bool => filled($state))
                ->afterStateHydrated(fn ($component) => $component->state(null))
                ->dehydrateStateUsing(fn ($state): string => Hash::make($state)),

            Repeater::make('contacts')
                ->relationship()
                ->defaultItems(1)
                ->schema([
                    PhoneInput::make('phone')
                        ->defaultCountry('AE')
                        ->disallowDropdown()
                        ->showFlags(false)
                        ->countrySearch(false)
                        ->validateFor('AE')
                        ->required(),
                ])
                ->columns(),
        ]);
    }
}
