<?php

use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneInputColumn;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages\EditUser;
use Ysfkaya\FilamentPhoneInput\Tests\Fixtures\FilamentPhoneInputUserResource\Pages\ListUsers;
use Ysfkaya\FilamentPhoneInput\Tests\TestCase;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

uses(TestCase::class);

it('hydrate the phone number given specific number and country', function () {
    FilamentPhoneInputUser::create([
        'name' => 'test',
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'phone' => '(555) 123-4567',
        'phone_country' => 'US',
    ]);

    FilamentPhoneInputUserResource::phoneInput(fn (PhoneInput $input) => $input->countryStatePath('phone_country'));

    livewire(EditUser::class, ['record' => 1])
        ->assertSuccessful()
        ->assertSet('data.phone', '+15551234567');
});

it('hydrate the phone number given specific number and default country', function () {
    FilamentPhoneInputUser::create([
        'name' => 'test',
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'phone' => '212-975-4846',
    ]);

    FilamentPhoneInputUserResource::phoneInput(fn (PhoneInput $input) => $input->defaultCountry('US'));

    livewire(EditUser::class, ['record' => 1])
        ->assertSuccessful()
        ->assertSet('data.phone', '+12129754846');
});

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

it('can saves the country code to the database', function () {
    phoneTest(
        fn (PhoneInput $p) => $p->countryStatePath('phone_country')
    )->fillForm([
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password',
        'phone' => '+905301111111',
        'phone_country' => 'TR',
    ])->call('create')->assertHasNoErrors();

    assertDatabaseHas(FilamentPhoneInputUser::class, [
        'phone' => '0530 111 11 11',
        'phone_country' => 'TR',
    ]);
});

test('the enum returns the libphonenumber format', function () {
    expect(PhoneInputNumberType::E164->toLibPhoneNumberFormat())->toBe(0);
    expect(PhoneInputNumberType::INTERNATIONAL->toLibPhoneNumberFormat())->toBe(1);
    expect(PhoneInputNumberType::NATIONAL->toLibPhoneNumberFormat())->toBe(2);
    expect(PhoneInputNumberType::RFC3966->toLibPhoneNumberFormat())->toBe(3);
});

test('table column formats the phone number', function ($type) {
    FilamentPhoneInputUser::create([
        'name' => 'test',
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'phone' => '+905301111111',
    ]);

    FilamentPhoneInputUserResource::phoneTableColumn(fn (PhoneInputColumn $column) => $column->displayFormat(PhoneInputNumberType::from($type)));

    livewire(ListUsers::class)
        ->assertSuccessful()
        ->assertSee(
            match ($type) {
                PhoneInputNumberType::E164->value => '+905301111111',
                PhoneInputNumberType::INTERNATIONAL->value => '+90 530 111 11 11',
                PhoneInputNumberType::NATIONAL->value => '0530 111 11 11',
                PhoneInputNumberType::RFC3966->value => 'tel:+90-530-111-11-11',
            }
        );
})->with([
    [PhoneInputNumberType::E164->value],
    [PhoneInputNumberType::INTERNATIONAL->value],
    [PhoneInputNumberType::NATIONAL->value],
    [PhoneInputNumberType::RFC3966->value],
]);

test('table column formats with country code', function ($type) {
    FilamentPhoneInputUser::create([
        'name' => 'test',
        'email' => fake()->unique()->safeEmail(),
        'password' => bcrypt('password'),
        'phone' => '0530 111 11 11',
        'phone_country' => 'TR',
    ]);

    FilamentPhoneInputUserResource::phoneTableColumn(fn (PhoneInputColumn $column) => $column->countryColumn('phone_country')->displayFormat(PhoneInputNumberType::from($type)));

    livewire(ListUsers::class)
        ->assertSuccessful()
        ->assertSee(
            match ($type) {
                PhoneInputNumberType::E164->value => '+905301111111',
                PhoneInputNumberType::INTERNATIONAL->value => '+90 530 111 11 11',
                PhoneInputNumberType::NATIONAL->value => '0530 111 11 11',
                PhoneInputNumberType::RFC3966->value => 'tel:+90-530-111-11-11',
            }
        );
})->with([
    [PhoneInputNumberType::E164->value],
    [PhoneInputNumberType::INTERNATIONAL->value],
    [PhoneInputNumberType::NATIONAL->value],
    [PhoneInputNumberType::RFC3966->value],
]);

it('does not use debugging functions', function () {
    expect(['dd', 'dump', 'var_dump', 'print_r', 'ray'])->not->toBeUsed();
});
