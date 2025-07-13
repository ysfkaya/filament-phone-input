<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class PhoneInputNullStatmentTest extends BrowserTestCase
{
    protected ?string $resource = FilamentPhoneInputUserResource::class;

    #[Test]
    public function it_sets_null_value_after_reinit()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser
                ->pause(300)
                ->waitFor('@phone-input.form.phone')
                ->type('#form\\.name', 'John Doe')
                ->type('#form\\.password', 'password')
                ->type('#form\\.email', 'john@doe.com')
                ->pause(300)
                ->typeSlowly('@phone-input.form.phone input.fi-input', '5301111111')
                ->pause(300)
                ->click('button[wire\\:click="createAnother"]')
                ->pause(750)
                ->assertValue('@phone-input.form.phone input.fi-input', null)
        );
    }
}
