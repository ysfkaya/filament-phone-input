<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputAffixActionsTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputAffixActionsResource::class;

    /** @test */
    public function it_should_be_copy_contact_to_whatsapp()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.contact_number')
                ->pause(300)
                ->typeSlowly('@phone-input.data.contact_number input.fi-input', '5555555555')
                ->pause(400)
                ->click('button[title="Copy contact to whats app"')
                ->waitFor('@phone-input.data.whatsapp_number')
                ->assertValue('@phone-input.data.whatsapp_number input.fi-input', '0555 555 55 55')
        );
    }
}

class PhoneInputAffixActionsResource extends FilamentPhoneInputUserResource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                PhoneInput::make('contact_number')
                    ->label('Contact Number')
                    ->required()
                    ->debounce(350)
                    ->suffixAction(
                        Action::make('copyContactToWhatsApp')
                            ->icon('heroicon-m-clipboard')
                            ->action(function ($set, $state) {
                                $set('whatsapp_number', $state);
                            })
                    ),
                PhoneInput::make('whatsapp_number')
                    ->label('WhatsApp Number')
                    ->debounce(),
            ]);
    }
}
