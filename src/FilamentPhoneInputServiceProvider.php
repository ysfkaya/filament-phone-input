<?php

namespace Ysfkaya\FilamentPhoneInput;

use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Route;

class FilamentPhoneInputServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-phone-input';

    protected array $styles = [
        'filament-phone-input' => __DIR__.'/../dist/css/filament-phone-input.css',
        'intl-tel-input' => __DIR__.'/../dist/css/intl-tel-input.css',
    ];

    protected array $beforeCoreScripts = [
        'filament-phone-input' => __DIR__.'/../dist/js/filament-phone-input.js',
    ];

    protected array $scripts = [
        'intl-tel-input-utils' => __DIR__.'/../dist/intl-tel-input/utils.js',
    ];

    public function packageBooted(): void
    {
        parent::packageBooted();

        Route::get('/filament-phone-input-flags.png', function () {
            return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags.png');
        });

        Route::get('/filament-phone-input-flags@2x.png', function () {
            return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags@2x.png');
        });
    }
}
