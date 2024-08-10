<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputStrictModeTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputStrictModeResource::class;

    /** @test */
    public function it_should_be_not_allow_string()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.phone')
                ->typeSlowly('@phone-input.data.phone input.fi-input', 'not allow string 5301111111')
                ->pause(300)
                ->assertValue('@phone-input.data.phone input.fi-input', '(530) 111-1111')
        );
    }
}

class PhoneInputStrictModeResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->strictMode()->initialCountry('US');
    }
}
