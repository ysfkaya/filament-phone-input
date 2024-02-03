<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputAutoInsertTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputAutoInsertResource::class;

    /** @test */
    public function it_should_be_auto_insert_dial_code()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.phone')
                ->pause(300)
                ->assertValue('@phone-input.data.phone input.fi-input', '+90')
        );
    }
}

class PhoneInputAutoInsertResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->initialCountry('TR')->autoInsertDialCode()->nationalMode(false);
    }
}
