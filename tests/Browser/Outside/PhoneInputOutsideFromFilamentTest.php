<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Browser\Outside;

use Illuminate\Support\Facades\Route;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Attributes\Test;
use Ysfkaya\FilamentPhoneInput\Tests\BrowserTestCase;

class PhoneInputOutsideFromFilamentTest extends BrowserTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeServingApplication(function () {
            app('livewire')->component(Component::class);

            Route::get('/world', Component::class)->name('outside')->middleware('web');
        });
    }

    protected function tearDown(): void
    {
        $this->afterServingApplication();

        parent::tearDown();
    }

    #[Test]
    public function it_displays_phone_input_from_outside_the_filament()
    {
        return $this->browse(function (Browser $browser) {
            $browser->visit('/world')
                ->waitForLivewireToLoad()
                ->pause(250)
                ->assertPresent('@phone-input.form.phone .iti__country-container');
        });
    }
}
