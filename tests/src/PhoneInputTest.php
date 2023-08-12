<?php

use function Pest\Laravel\assertDatabaseHas;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\TestCase;

uses(TestCase::class);

it('should be fill the phone input', function ($type) {
    phoneTest(
        fn (PhoneInput $p) => $p->inputNumberFormat(PhoneInputNumberType::from($type))
    )->fillForm([
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password',
        'phone' => '+905301111111',
    ])->call('create')->assertHasNoErrors();

    assertDatabaseHas(FilamentPhoneInputUser::class, [
        'phone' => match ($type) {
            PhoneInputNumberType::E164->value => '+905301111111',
            PhoneInputNumberType::INTERNATIONAL->value => '+90 530 111 11 11',
            PhoneInputNumberType::NATIONAL->value => '0530 111 11 11',
            PhoneInputNumberType::RFC3966->value => 'tel:+90-530-111-11-11',
        },
    ]);
})->with([
    PhoneInputNumberType::E164->value,
    PhoneInputNumberType::INTERNATIONAL->value,
    PhoneInputNumberType::NATIONAL->value,
    PhoneInputNumberType::RFC3966->value,
]);

it('validate for', function (string $country, string $phone, bool $pass, $type = null, $lenient = false) {
    $test = phoneTest(
        fn (PhoneInput $p) => $p->validateFor($country, $type, $lenient)
    )->fillForm([
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password',
        'phone' => $phone,
    ])->call('create');

    if ($pass) {
        $test->assertHasNoFormErrors();
    } else {
        $test->assertHasFormErrors(['phone']);
    }
})->with([
    ['AUTO', '+905301111111', true],
    ['TR', '+18143511527', false],
    ['TR', '5301111111', true, null, true],
    ['TR', '0530 111 11 11', true, PhoneInputNumberType::NATIONAL->toLibPhoneNumberFormat()],
]);

todo('it sets the country state while using countryStatePath');
todo('the enum returns the libphonenumber format');

it('does not use debugging functions', function () {
    expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])->not->toBeUsed();
});
