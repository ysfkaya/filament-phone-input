<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class ListUsers extends ListRecords
{
    public static string $resource = FilamentPhoneInputUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
