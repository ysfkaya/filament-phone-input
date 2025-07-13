<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputDisplayFormatTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputDisplayFormatResource::class;

    #[Test]
    public function it_should_be_display_number_format_as_international()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.form.phone')
                ->click('@phone-input.form.phone input.fi-input')
                ->typeSlowly('@phone-input.form.phone input.fi-input', '5301111111')
                ->pause(300)
                ->assertValue('@phone-input.form.phone input.fi-input', '+90 530 111 11 11')
        );
    }
}

class PhoneInputDisplayFormatResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->initialCountry('TR')->displayNumberFormat(PhoneInputNumberType::INTERNATIONAL)->formatAsYouType(false);
    }
}
