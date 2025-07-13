<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputAffixActionsTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputAffixActionsResource::class;

    #[Test]
    public function it_should_be_able_to_copy_contact_to_whatsapp()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.form.contact_number')
                ->pause(300)
                ->typeSlowly('@phone-input.form.contact_number input.fi-input', '5555555555')
                ->pause(400)
                ->click('button[title="Copy contact to whatsapp"]')
                ->waitFor('@phone-input.form.whatsapp_number')
                ->assertValue('@phone-input.form.whatsapp_number input.fi-input', '+905555555555')
        );
    }
}

class PhoneInputAffixActionsResource extends FilamentPhoneInputUserResource
{
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                PhoneInput::make('contact_number')
                    ->label('Contact Number')
                    ->required()
                    ->debounce(350)
                    ->initialCountry('TR')
                    ->displayNumberFormat(PhoneInputNumberType::E164)
                    ->formatAsYouType(false)
                    ->suffixAction(
                        Action::make('copyContactToWhatsapp')
                            ->icon('heroicon-m-clipboard')
                            ->action(function ($set, $state) {
                                $set('whatsapp_number', $state);
                            })
                    ),
                PhoneInput::make('whatsapp_number')
                    ->label('WhatsApp Number')
                    ->initialCountry('TR')
                    ->displayNumberFormat(PhoneInputNumberType::E164)
                    ->formatAsYouType(false)
                    ->debounce(),
            ]);
    }
}
