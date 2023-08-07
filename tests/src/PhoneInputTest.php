<?php

use Ysfkaya\FilamentPhoneInput\Tests\TestCase;

uses(TestCase::class);

it('does not use debugging functions', function () {
    expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])->not->toBeUsed();
});
