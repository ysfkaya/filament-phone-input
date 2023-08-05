<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputPreferedCountriesTest extends BrowserTestCase
{
    protected string $resource = PhoneInputPreferedCountriesResource::class;

    /** @test */
    public function it_should_be_render_with_prefered_countries()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.data.phone .iti__selected-flag')
                ->pause(300)
                ->with('@phone-input.data.phone .iti__country-list', function (Browser $browser) {
                    $browser->assertDataAttribute('.iti__preferred:nth-child(1)', 'country-code', 'tr');
                    $browser->assertDataAttribute('.iti__preferred:nth-child(2)', 'country-code', 'gb');
                    $browser->assertDataAttribute('.iti__preferred:nth-child(3)', 'country-code', 'us');
                })
        );
    }
}

class PhoneInputPreferedCountriesResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->preferredCountries(['tr', 'gb', 'us']);
    }
}
