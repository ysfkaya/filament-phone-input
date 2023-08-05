<?php

use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tests\TestCase;

uses(TestCase::class);

it('should be render', function () {
    phoneTest(
        fn (PhoneInput $p) => $p->label('Test Phone Label')
    )->assertSee('Test Phone Label');
});

todo('it should be render with value');

it('does not use debugging functions', function () {
    expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])->not->toBeUsed();
});
