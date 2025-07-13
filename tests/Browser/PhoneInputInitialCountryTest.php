<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputInitialCountryTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputFlagResource::class;

    #[Test]
    public function it_should_be_render_with_initial_country()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.form.phone')
                ->pause(300)
                ->with('@phone-input.form.phone', function (Browser $browser) {
                    $browser->assertAttribute('.iti__selected-country', 'title', 'Turkey: +90');
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
