<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputDisplayFormatTest extends BrowserTestCase
{
    protected string $resource = PhoneInputDisplayFormatResource::class;

    /** @test */
    public function it_should_be_display_number_format_as_international()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.data.phone')
                ->pause(300)
                ->typeSlowly('@phone-input.data.phone input', '5301111111')
                ->pause(300)
                ->assertValue('@phone-input.data.phone input', '+90 530 111 11 11')
        );
    }
}

class PhoneInputDisplayFormatResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->initialCountry('TR')->displayNumberFormat(PhoneInputNumberType::INTERNATIONAL);
    }
}
