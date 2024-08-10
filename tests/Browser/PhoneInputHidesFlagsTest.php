<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputHidesFlagsTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputHidesFlagResource::class;

    /** @test */
    public function it_should_not_show_flags()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.phone')
                ->pause(500)
                ->assertPresent('.iti__flag.iti__globe')
        );
    }
}

class PhoneInputHidesFlagResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->showFlags(false);
    }
}
