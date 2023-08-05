<?php

namespace Ysfkaya\FilamentPhoneInput\Tests;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Livewire\Features\SupportTesting\DuskBrowserMacros;
use Orchestra\Testbench\Dusk\TestCase as Orchestra;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputPanelProvider;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class DuskTestCase extends Orchestra
{
    use TestSuite{
        TestSuite::getEnvironmentSetUp as getTestSuiteEnvironmentSetUp;
    }

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->makeACleanSlate();
        });

        $this->beforeApplicationDestroyed(function () {
            $this->makeACleanSlate();
        });

        parent::setUp();

        Browser::mixin(new DuskBrowserMacros);

        $this->artisan('filament:assets');
    }

    public function makeACleanSlate()
    {
        Artisan::call('view:clear');
    }

    public function phoneTest(callable $visitCallback, callable $cb = null)
    {
        $this->beforeServingApplication(function () use ($cb) {
            FilamentPhoneInputPanelProvider::$phoneInputCallback = $cb;
        });

        return $this->browse(function (Browser $browser) use ($visitCallback) {
            $visitCallback(
                $browser
                    ->login()
                    ->visit(FilamentPhoneInputUserResource::getUrl('create', isAbsolute: false))
            );
        });
    }

    protected function user()
    {
        return FilamentPhoneInputUser::create([
            'name' => 'Test User',
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        $this->getTestSuiteEnvironmentSetUp($app);

        $app['config']->set('app.debug', true);
        $app['config']->set('database.connections.sqlite.database', database_path('database.sqlite'));
    }
}
