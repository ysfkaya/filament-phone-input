<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputFullScreenPopupFlagTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputFullScreenPopupFlagResource::class;

    #[Test]
    public function it_should_show_fullscreen_popup()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->waitFor('@phone-input.form.phone')
                ->pause(300)
                ->click('@phone-input.form.phone .iti__selected-country')
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
