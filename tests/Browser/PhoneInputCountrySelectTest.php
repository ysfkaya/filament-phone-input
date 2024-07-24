<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputCountrySelectTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputCountrySelectResource::class;

    /** @test */
    public function it_should_be_hidden_country_select_input()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.phone')
                ->pause(300)
                ->click('@phone-input.data.phone .iti__selected-country')
                ->pause(300)
                ->assertMissing('.iti__search-input')
        );
    }
}

class PhoneInputCountrySelectResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->countrySearch(false);
    }
}
