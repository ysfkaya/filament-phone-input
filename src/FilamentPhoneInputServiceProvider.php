<?php

namespace Ysfkaya\FilamentPhoneInput;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentPhoneInputServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-phone-input')
            ->hasViews()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishAssets();
                $command->askToStarRepoOnGitHub('ysfkaya/filament-phone-input');
            });
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Css::make('filament-phone-input', __DIR__ . '/../dist/css/filament-phone-input.css')->loadedOnRequest(),
            AlpineComponent::make('filament-phone-input', __DIR__ . '/../dist/js/filament-phone-input.js'),
        ], package: 'ysfkaya/filament-phone-input');

        $this->publishes([
            $this->package->basePath('/../images/vendor/intl-tel-input/build') => public_path("vendor/{$this->package->shortName()}"),
        ], "{$this->package->shortName()}-assets");
    }
}
