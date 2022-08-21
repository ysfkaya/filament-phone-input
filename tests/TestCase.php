<?php

namespace Ysfkaya\FilamentPhoneInput\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Ysfkaya\FilamentPhoneInput\FilamentPhoneInputServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FilamentPhoneInputServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }
}
