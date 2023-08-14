<?php

namespace Ysfkaya\FilamentPhoneInput;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Route;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPhoneInputServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-phone-input')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('filament-phone-input', __DIR__.'/../dist/css/filament-phone-input.css')->loadedOnRequest(),
            AlpineComponent::make('filament-phone-input', __DIR__.'/../dist/js/filament-phone-input.js'),
        ], package: 'ysfkaya/filament-phone-input');

        Route::get('/phone-input-flags.png', function () {
            return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags.png');
        });

        Route::get('/phone-input-flags@2x.png', function () {
            return response()->file(__DIR__.'/../images/vendor/intl-tel-input/build/flags@2x.png');
        });
    }
}
