<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputFullScreenPopupFlagTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputFullScreenPopupFlagResource::class;

    /** @test */
    public function it_should_show_fullscreen_popup()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.data.phone')
                ->pause(300)
                ->click('@phone-input.data.phone .iti__selected-country')
                ->pause(300)
                ->assertPresent('.iti--fullscreen-popup')
        );
    }
}

class PhoneInputFullScreenPopupFlagResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->useFullscreenPopup();
    }
}
