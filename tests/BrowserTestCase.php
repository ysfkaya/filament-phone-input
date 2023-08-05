<?php

namespace Ysfkaya\FilamentPhoneInput\Tests;

use Illuminate\Support\Facades\Artisan;
use Laravel\Dusk\Browser;
use Livewire\Features\SupportTesting\DuskBrowserMacros;
use Orchestra\Testbench\Dusk\TestCase as Orchestra;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputPanelProvider;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;

class BrowserTestCase extends Orchestra
{
    use TestSuite{
        TestSuite::getEnvironmentSetUp as getTestSuiteEnvironmentSetUp;
    }

    protected string $resource;

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

    public function createApplication()
    {
        FilamentPhoneInputPanelProvider::resourceClass($this->resource);

        return parent::createApplication();
    }

    public function makeACleanSlate()
    {
        Artisan::call('view:clear');
    }

    public function phoneTest(callable $visitCallback)
    {
        return $this->browse(function (Browser $browser) use ($visitCallback) {
            $visitCallback(
                $browser
                    ->login()
                    ->visit($this->resource::getUrl('create', isAbsolute: false))
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
