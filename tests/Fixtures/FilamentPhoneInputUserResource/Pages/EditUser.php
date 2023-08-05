<?php

namespace Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;

class EditUser extends EditRecord
{
    protected static string $resource = FilamentPhoneInputUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
