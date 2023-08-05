<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputInitialCountryTest extends BrowserTestCase
{
    protected string $resource = PhoneInputFlagResource::class;

    /** @test */
    public function it_should_be_render_with_initial_country()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.data.phone')
                ->pause(300)
                ->with('@phone-input.data.phone', function (Browser $browser) {
                    $browser->assertAttribute('.iti__selected-flag', 'title', 'Turkey (Türkiye): +90');
                })
        );
    }
}

class PhoneInputFlagResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->initialCountry('TR');
    }
}
