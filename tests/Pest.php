<?php

use function Pest\Livewire\livewire;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages\CreateUser;

function phoneTest(callable $cb = null)
{
    FilamentPhoneInputUserResource::phoneInput($cb);

    return livewire(CreateUser::class);
}
