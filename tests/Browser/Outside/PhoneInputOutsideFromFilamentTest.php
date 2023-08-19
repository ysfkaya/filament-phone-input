<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser\Outside;

use Illuminate\Support\Facades\Route;
use Laravel\Dusk\Browser;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;

class PhoneInputOutsideFromFilamentTest extends BrowserTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->tweakApplication(function () {
            app('livewire')->component(Component::class);

            Route::get('/world', Component::class)->name('outside')->middleware('web');
        });
    }

    protected function tearDown(): void
    {
        $this->removeApplicationTweaks();

        parent::tearDown();
    }

    /** @test */
    public function it_displays_phone_input_from_outside_the_filament()
    {
        return $this->browse(function (Browser $browser) {
            $browser->visit('/world')
                ->waitForLivewireToLoad()
                ->pause(250)
                ->withIn('@phone-input.data.phone', function (Browser $browser) {
                    $browser->assertScript('document.querySelector(".iti__flag-container").nodeName', 'DIV');
                });
        });
    }
}
