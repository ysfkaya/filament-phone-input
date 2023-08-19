<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputSeperateDialCodeTest extends BrowserTestCase
{
    protected ?string $resource = PhoneInputSeparateDialCodeResource::class;

    /** @test */
    public function it_should_be_render_with_separate_dial_code()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->click('@phone-input.data.phone')
                ->pause(300)
                ->with('@phone-input.data.phone', function (Browser $browser) {
                    $browser->assertSeeIn('.iti__selected-dial-code', '+90');
                })
        );
    }
}

class PhoneInputSeparateDialCodeResource extends FilamentPhoneInputUserResource
{
    public static function getPhoneInput(): ?PhoneInput
    {
        return parent::getPhoneInput()->initialCountry('TR')->separateDialCode();
    }
}
