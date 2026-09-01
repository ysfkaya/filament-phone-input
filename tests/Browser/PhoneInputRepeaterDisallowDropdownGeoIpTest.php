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

class PhoneInputRepeaterDisallowDropdownGeoIpTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputRepeaterDisallowDropdownGeoIpResource::class;

    #[Test]
    public function it_saves_phone_number_in_repeater_when_dropdown_is_disallowed_and_geoip_resolves(): void
    {
        $this->phoneTest(function (Browser $browser) {
            $browser
                ->waitFor('input[type="tel"]')
                ->waitUntil('window.phoneInputGeoIpLookup', 5)
                ->type('#form\\.name', 'John Doe')
                ->type('#form\\.password', 'password')
                ->type('#form\\.email', fake()->unique()->safeEmail())
                ->pause(300)
                ->typeSlowly('input[type="tel"]', '0501234567')
                ->pause(500)
                ->press('Create')
                ->pause(1000);

            $errors = collect($browser->driver->manage()->getLog('browser'))
                ->filter(fn (array $log): bool => $log['level'] === 'SEVERE' && ! str_contains($log['message'], 'Failed to load resource'))
                ->pluck('message');

            $this->assertEmpty($errors->all(), 'JS errors: ' . $errors->implode(PHP_EOL));
        });

        $this->assertDatabaseHas('filament_phone_input_contacts', [
            'phone' => '+971501234567',
        ]);
    }
}

class PhoneInputRepeaterDisallowDropdownGeoIpResource extends FilamentPhoneInputUserResource
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
                        ->ipLookup(fn () => 'AE')
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
