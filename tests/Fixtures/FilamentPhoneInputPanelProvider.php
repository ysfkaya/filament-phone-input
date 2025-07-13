<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\CreateFilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\EditFilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\ListFilamentPhoneInputUsers;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Schemas\FilamentPhoneInputUserForm;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Tables\FilamentPhoneInputUsersTable;

class FilamentPhoneInputPanelProvider extends PanelProvider
{
    protected static string $resourceClass = FilamentPhoneInputUserResource::class;

    public static function resourceClass($class)
    {
        self::$resourceClass = $class;

        CreateFilamentPhoneInputUser::$resource = $class;
        EditFilamentPhoneInputUser::$resource = $class;
        ListFilamentPhoneInputUsers::$resource = $class;

        FilamentPhoneInputUserForm::$resource = $class;
        FilamentPhoneInputUsersTable::$resource = $class;
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->resources([
                self::$resourceClass,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
