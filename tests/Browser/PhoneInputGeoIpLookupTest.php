<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputGeoIpLookupTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputGeoIpLookupResource::class;

    /** @test */
    public function it_should_be_render_with_ip_lookup()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitUntil('window.phoneInputGeoIpLookup', 5)
                ->with('@phone-input.data.phone', function (Browser $browser) {
                    $browser->assertAttribute('.iti__selected-country', 'title', 'Azerbaijan: +994');
                })
                ->assertCookieValue('intlTelInputSelectedCountry', 'AZ', decrypt: false)
        );
    }
}

class PhoneInputGeoIpLookupResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->ipLookup(fn () => 'AZ');
    }
}
