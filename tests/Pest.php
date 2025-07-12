<?php

use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUsers\Pages\CreateFilamentPhoneInputUser;

use function Pest\Livewire\livewire;

function phoneTest(?callable $cb = null)
{
    FilamentPhoneInputUserResource::phoneInput($cb);

    return livewire(CreateFilamentPhoneInputUser::class);
}
