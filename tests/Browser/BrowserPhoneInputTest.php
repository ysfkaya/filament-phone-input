<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser;

use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Tests\DuskTestCase;

class BrowserPhoneInputTest extends DuskTestCase
{
    /** @test */
    public function it_should_be_render_with_initial_country()
    {
        $this->phoneTest(
            fn (Browser $browser) => $browser->pause(50000)->assertSee('Turkey (Türkiye): +90'),
            fn ($input) => $input->initialCountry('AR')
        );
    }
}
