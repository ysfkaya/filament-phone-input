<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputOnlyCountriesTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputOnlyCountriesResource::class;

    /** @test */
    public function it_should_be_render_with_only_countries()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.data.phone .iti__selected-flag')
                ->pause(700)
                ->with('@phone-input.data.phone .iti__country-list', function (Browser $browser) {
                    $browser->assertDataAttribute('.iti__country:nth-child(1)', 'country-code', 'az');
                    $browser->assertDataAttribute('.iti__country:nth-child(2)', 'country-code', 'ru');
                    $browser->assertDataAttribute('.iti__country:nth-child(3)', 'country-code', 'tr');
                    $browser->assertDataAttribute('.iti__country:nth-child(4)', 'country-code', 'gb');
                    $browser->assertDataAttribute('.iti__country:nth-child(5)', 'country-code', 'us');
                })
        );
    }
}

class PhoneInputOnlyCountriesResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->onlyCountries(['tr', 'gb', 'us', 'az', 'ru'])->preferredCountries([]);
    }
}
