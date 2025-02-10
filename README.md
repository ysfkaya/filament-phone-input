# Filament Phone Input

<p align="center"><img src="https://raw.githubusercontent.com/ysfkaya/filament-phone-input/main/screenshots/input.png" alt="Filament Phone Input"></p>

<p align="center" class="flex items-center gap-2">
<a href="https://packagist.org/packages/ysfkaya/filament-phone-input"><img src="https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white" style="max-width: 100%"></a>
<a href="https://github.com/ysfkaya/filament-phone-input/actions?query=workflow%3Arun-tests+branch%3Amain"><img src="https://img.shields.io/github/actions/workflow/status/ysfkaya/filament-phone-input/run-tests.yml?style=for-the-badge&logo=github&label=TESTS" alt="GitHub Tests Action Status" data-canonical-src="https://img.shields.io/github/actions/workflow/status/ysfkaya/filament-phone-input/run-tests.yml?branch=main&amp;label=tests&style=for-the-badge" style="max-width: 100%;"></a>
<a href="https://packagist.org/packages/ysfkaya/filament-phone-input/stats" rel="nofollow"><img src="https://img.shields.io/packagist/dt/ysfkaya/filament-phone-input.svg?color=rgb(249%20115%2022)&style=for-the-badge" alt="Total Downloads" style="max-width: 100%;"></a>
<a href="https://packagist.org/packages/ysfkaya/filament-phone-input" rel="nofollow"><img src="https://img.shields.io/packagist/v/ysfkaya/filament-phone-input?style=for-the-badge&logo=packagist&label=Version" style="max-width: 100%;"></a>
<a target="_blank" rel="noopener noreferrer nofollow" href="https://filamentphp.com/"><img src="https://img.shields.io/badge/filament-3-rgb(235%2068%2050)?style=for-the-badge&amp;logo=laravel" alt="Filament Version" style="max-width: 100%;"></a>
<a target="_blank" rel="noopener noreferrer nofollow" href="#"><img src="https://img.shields.io/badge/php-^8.1-rgb(249%20115%2022)?style=for-the-badge&logo=php" alt="PHP Version" style="max-width: 100%;"></a>
</p>

<h2 class="filament-hidden">Table of Contents</h2>

<ul class="table-of-contents filament-hidden" dir="auto">
<li>
<a href="#introduction">Introduction</a>
</li>
<li>
<a href="#installation">Installation</a>
</li>
<li>
<a href="#quick-preview">Quick Preview</a>
</li>
<li>
<a href="#usage">Usage</a>
<ul>
<li>
<a href="#separate-country-code">Separate Country Code</a>
</li>
<li>
<a href="#default-country">Default Country</a>
</li>
<li>
<a href="#validation">Validation</a>
</li>
<li>
<a href="#display-number-format">Display Number Format</a>
</li>
<li>
<a href="#input-number-format">Input Number Format</a>
</li>
<li>
<a href="#focus-input-type">Focus Input Type</a>
</li>
<li>
<a href="#disallow-dropdown">Disallow Dropdown</a>
</li>
<li>
<a href="#hide-flags">Hide Flags</a>
</li>
<li>
<a href="#show-fullscreen-popup">Show Fullscreen Popup</a>
</li>
<li>
<a href="#auto-placeholder">Auto Placeholder</a>
</li>
<li>
<a href="#custom-container">Custom Container</a>
</li>
<li>
<a href="#exclude-countries">Exclude Countries</a>
</li>
<li>
<a href="#initial-country">Initial Country</a>
</li>
<li>
<a href="#only-countries">Only Countries</a>
</li>
<li>
<a href="#format-on-display">Format On Display</a>
</li>
<li>
<a href="#geo-ip-lookup">Geo Ip Lookup</a>
</li>
<li>
<a href="#placeholder-number-type">Placeholder Number Type</a>
</li>
<li>
<a href="#country-order">Country Order</a>
</li>
<li>
<a href="#country-search">Country Search</a>
</li>
<li>
<a href="#strict-mode">Strict Mode</a>
</li>
<li>
<a href="#cookie-name">Cookie Name</a>
</li>
<li>
<a href="#locale">Locale</a>
</li>
<li>
<a href="#i18n">i18n</a>
</li>
<li>
<a href="#format-as-you-type">Format as You Type</a>
</li>
<li>
<a href="#using-the-phoneinput-outside-of-filament">Using the PhoneInput outside of Filament</a>
</li>
<li>
<a href="#more">More</a>
</li>
</ul>
</li>
<li>
<a href="#troubleshooting">Troubleshooting</a>
<ul>
<li>
<a href="#propaganistaslaravelphoneexceptionsnumberparseexception-error">Propaganistas\LaravelPhone\Exceptions\NumberParseException error</a>
</li>
</ul>
</li>
<li>
<a href="#upgrade-from-2x">Upgrade From 2.x</a>
<ul>
<li>
<a href="#deprecated">Deprecated</a>
</li>
</ul>
</li>
<li>
<a href="#testing">Testing</a>
</li>
<li>
<a href="#changelog">Changelog</a>
</li>
<li>
<a href="#credits">Credits</a>
</li>
<li>
<a href="#license">License</a>
</li>
</ul>

## Introduction

This package provides a phone input component for [Laravel Filament](https://filamentphp.com/). It uses [International Telephone Input](https://github.com/jackocnr/intl-tel-input) to provide a dropdown of countries and flags.

This package also includes with [Laravel Phone](https://github.com/propaganistas/laravel-phone) package. You can use all the methods of the Laravel Phone package.

> [!NOTE]
> For **Filament 2.x** use **[1.x](https://github.com/ysfkaya/filament-phone-input/tree/1.x)** branch

## Installation

You can install the package via composer:

```bash
composer require ysfkaya/filament-phone-input
```

Publish the assets:

```bash
php artisan filament:assets
php artisan filament-phone-input:install
```

## Quick Preview

```php
PhoneInput::make(string $name)
    ->countryStatePath(string | Closure $statePath, bool $isStatePathAbsolute)
    ->validateFor(string | array $country = 'AUTO', int | array | null $type = null, bool $lenient = false)
    ->defaultCountry(string $value)
    ->ipLookup(Closure $callback)
    ->disableLookup()
    ->enableIpLookup(bool | Closure $value = true)
    ->inputNumberFormat(PhoneInputNumberType | Closure $format)
    ->displayNumberFormat(PhoneInputNumberType | Closure $format)
    ->focusNumberFormat(PhoneInputNumberType | Closure $format)
    ->placeholderNumberType(PhoneInputNumberType | Closure $format)
    ->disallowDropdown()
    ->allowDropdown(bool | Closure $value = true)
    ->autoPlaceholder(string $value = 'polite')
    ->containerClass(string | Closure $value)
    ->countryOrder(array | Closure | null $value)
    ->countrySearch(bool | Closure $value = true)
    ->customPlaceholder(string | RawJs | Closure | null $value)
    ->dropdownContainer(string | null | Closure $value)
    ->excludeCountries(array | Closure $value)
    ->fixDropdownWidth(bool | Closure $value = true)
    ->formatAsYouType(bool | Closure $value = true)
    ->formatOnDisplay(bool | Closure $value = true)
    ->i18n(array | Closure $value)
    ->initialCountry(string | Closure $value)
    ->nationalMode(bool | Closure $value = true)
    ->onlyCountries(array | Closure $value)
    ->showFlags(bool | Closure $value = true)
    ->separateDialCode(bool | Closure $value = true)
    ->useFullscreenPopup(bool | Closure $value = true)
    ->strictMode(bool | Closure $value = true)
    ->cookieName(string | Closure $value)
    ->locale(string | Closure $value)
    ->customOptions(array | Closure $value)
```

## Usage

```php
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;
use Ysfkaya\FilamentPhoneInput\Infolists\PhoneEntry;
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

  
    public static function infolists(Infolist $infolist): Infolist
    {
        return $infolist
            ->columns([
                Infolists\Components\TextEntry::make('name'),
                Tables\Columns\TextColumn::make('email'),
                PhoneEntry::make('phone')->displayFormat(PhoneInputNumberType::NATIONAL),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(ignoreRecord: true),

                PhoneInput::make('phone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),

                PhoneColumn::make('phone')->displayFormat(PhoneInputNumberType::NATIONAL)
            ]);
    }
```

#### Separate Country Code

---

Sometimes you may want to save the country code and the phone number in different columns. You can use the `countryStatePath` method to do that.

```php
PhoneInput::make('phone')
    ->countryStatePath('phone_country')
```

Table column:

```php
PhoneColumn::make('phone')
    ->countryColumn('phone_country')
```

Infolist entry:

```php
PhoneEntry::make('phone')
    ->countryColumn('phone_country')
```

When you use the `countryStatePath` method, the country code will be saved to the `phone_country` column and the phone number will be saved to the `phone` column.

#### Default Country

---

The default country value is will be used while parsing the phone number. If you can getting the `Number requires a country to be specified.` or `Number does not match the provided country` error, you should set the default country.

```php
PhoneInput::make('phone')
    ->defaultCountry('US'),
```

> [!NOTE]
> I think the main source of this problem is that there is no area code in the phone number previously recorded in your database. To fix this, `libphonenumber` expects a default phone number from us. Unfortunately, there is no ability to guess the country by phone number yet.


#### Validation

---

You may validate the phone number by using the `validateFor` method:

```php
PhoneInput::make('phone')
    ->validateFor(
        country: 'TR' | ['US', 'GB'], // default: 'AUTO'
        type: libPhoneNumberType::MOBILE | libPhoneNumberType::FIXED_LINE, // default: null
        lenient: true, // default: false
    ),
```

> [!WARNING]
> Add an extra translation to your `validation.php` file.

You can find more information about the validation [here](https://github.com/Propaganistas/Laravel-Phone#validation)

#### Display Number Format

---

You may set the display format of the phone number by passing a format string to the `displayNumberFormat` method. The default format is `NATIONAL`. That means the phone number will be displayed in the format of the selected country.

> Available formats are;

-   PhoneInputNumberType::E164
-   PhoneInputNumberType::INTERNATIONAL
-   PhoneInputNumberType::NATIONAL
-   PhoneInputNumberType::RFC3966

```php
PhoneInput::make('phone')
    ->displayNumberFormat(PhoneInputNumberType::E164),
```

<p align="left"><img src="https://raw.githubusercontent.com/ysfkaya/filament-phone-input/main/screenshots/display-number-format.png" alt="Filament Phone Input"></p>

#### Input Number Format

---

You may set the input value type by passing a type string to the `inputNumberFormat` method. The default type is `E164`. That means the phone number will be saved in the format of the selected country to the **database**.

```php
PhoneInput::make('phone')
    ->inputNumberFormat(PhoneInputNumberType::NATIONAL),
```

#### Focus Input Type

---

You may set the focus input type by passing a type string to the `focusNumberFormat` method. The default value is `false`.

```php
PhoneInput::make('phone')
    ->focusNumberFormat(PhoneInputNumberType::E164),
```

<p align="left"><img src="https://raw.githubusercontent.com/ysfkaya/filament-phone-input/main/screenshots/focus-input-type.gif" alt="Filament Phone Input"></p>

#### Disallow Dropdown

---

You may disable the dropdown by using the `disallowDropdown` method:

```php
PhoneInput::make('phone')
    ->disallowDropdown(),
```

<p align="left"><img src="https://raw.githubusercontent.com/ysfkaya/filament-phone-input/main/screenshots/disallowed-dropdown.png" alt="Filament Phone Input"></p>

#### Hide Flags

---

If you want to hide the flags, you may use the `showFlags` method:

```php
PhoneInput::make('phone')
    ->showFlags(false),
```

> [!WARNING]
> Must be used in combination with `separateDialCode` option, or with `disallowDropdown`

#### Show Fullscreen Popup

---

If you want to show the fullscreen popup on mobile devices, you may use the `useFullscreenPopup` method:

```php
PhoneInput::make('phone')
    ->useFullscreenPopup(),
```

#### Auto Placeholder

---

You may set the auto placeholder type by using the `autoPlaceholder` method:

```php
PhoneInput::make('phone')
    ->autoPlaceholder('aggressive'), // default is 'polite'
```

#### Custom Container

---

You may set the additional classes to add to the parent div by using the `customContainer` method:

```php
PhoneInput::make('phone')
    ->customContainer('w-full'),
```

#### Exclude Countries

---

You may set the exclude countries by using the `excludeCountries` method:

```php
PhoneInput::make('phone')
    ->excludeCountries(['us', 'gb']),
```

#### Initial Country

---

You may set the initial country by using the `initialCountry` method:

```php
PhoneInput::make('phone')
    ->initialCountry('us'),
```

#### Only Countries

---

You may set the only countries by using the `onlyCountries` method:

```php
PhoneInput::make('phone')
    ->onlyCountries(['tr','us', 'gb']),
```

<p align="left"><img src="https://raw.githubusercontent.com/ysfkaya/filament-phone-input/main/screenshots/only-countries.png" alt="Filament Phone Input"></p>

#### Format On Display

You may set the format on display by using the `formatOnDisplay` method:

```php
PhoneInput::make('phone')
    ->formatOnDisplay(false),
```

#### Geo Ip Lookup

---

In default, the package performs a geoIp lookup to set the initial country while mounting the component. To disable this feature, you may use the `disableLookup` method:

```php
PhoneInput::make('phone')
    ->disableLookup(),
```

You may set the geoIp lookup by using the `geoIpLookup` method:

```php
PhoneInput::make('phone')
    ->ipLookup(function () {
        return rescue(fn () => Http::get('https://ipinfo.io/json')->json('country'), app()->getLocale(), report: false);
    })
```

#### Placeholder Number Type

---

You may set the placeholder number type by using the `placeholderNumberType` method:

```php
PhoneInput::make('phone')
    ->placeholderNumberType('FIXED_LINE'),
```

#### Country Order

---

You may set the country order by using the `countryOrder` method:

```php
PhoneInput::make('phone')
    ->countryOrder(['us', 'gb', 'tr']),
```

#### Country Search

---

By default, the country search mode is set to active. You can disable it by using the `countrySearch` method:

```php
PhoneInput::make('phone')
    ->countrySearch(false),
```

#### Strict Mode

---

As the user types in the input, ignore any irrelevant characters. You can find more information about the strict mode in the [intl-tel-input](https://github.com/jackocnr/intl-tel-input#strictmode) documentation.

```php
PhoneInput::make('phone')
    ->strictMode(),
```

#### Cookie Name

---

When use the ip lookup feature, the package stores the country code in the cookie. The default cookie name is `intlTelInputSelectedCountry`. You can change it by using the `cookieName` method:

```php
PhoneInput::make('phone')
    ->cookieName('myCookieName'),
```

#### Locale

---

Default locale is coming from the `app()->getLocale()`. You can change it by using the `locale` method:

```php
PhoneInput::make('phone')
    ->locale('en'),
```

#### i18n

---

You can configure the localization of the component by using the `i18n` method. See the [intl-tel-input](https://github.com/jackocnr/intl-tel-input#i18n) for more information:

```php
PhoneInput::make('phone')
    ->i18n([
        // Country names
        'fr' => "Frankreich",
        'de' => "Deutschland",
        'es' => "Spanien",
        'it' => "Italien",
        'ch' => "Schweiz",
        'nl' => "Niederlande",
        'at' => "Österreich",
        'dk' => "Dänemark",
        // Other plugin text
        "selectedCountryAriaLabel" =>'Ausgewähltes Land',
        "countryListAriaLabel" =>'Liste der Länder',
        "searchPlaceholder" =>'Suchen',
    ]),
```

#### Format as You Type

---

Automatically format the number as the user types. You can disable it by using the `formatAsYouType` method:

```php
PhoneInput::make('phone')
    ->formatAsYouType(false),
```

#### Using the `PhoneInput` outside of Filament

A livewire component:

```php
<?php

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\View;
use Livewire\Component as Livewire;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class Component extends Livewire implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function mount()
    {
        // Do not forget to fill the form
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                PhoneInput::make('phone'),
            ])->statePath('data');
    }

    public function render()
    {
        return view('livewire.component');
    }
}
```

A blade component:

```blade
{{-- views/livewire/component.blade.php --}}
<div>
    {{ $this->form }}
</div>
```

A blade layout:

```blade
{{-- views/components/layouts/app.blade.php --}}
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script
        src="https://cdn.jsdelivr.net/npm/async-alpine@1.x.x/dist/async-alpine.script.js"
        defer
    ></script>
    <script
        src="https://unpkg.com/alpine-lazy-load-assets@latest/dist/alpine-lazy-load-assets.cdn.js"
        defer
    ></script>
</head>
<body>
    {{ $slot }}

    @stack('scripts')
</body>
</html>
```

#### More

---

You can find the more documentation for the intel tel input [here](https://intl-tel-input.com/)

## Troubleshooting

### `Propaganistas\LaravelPhone\Exceptions\NumberParseException` error

- Make sure you have set the [default country](#default-country). If you still receive this error, you can open an issue detailing what you did.

## Upgrade From 2.x

If you are upgrading from 2.x, you should publish the assets again.

```bash
php artisan filament:assets
php artisan filament-phone-input:install
```

### Deprecated

<!-- Diff -->

```diff
- public function autoInsertDialCode()
- public function localizedCountries()
- public function showSelectedDialCode()
- public function preferredCountries()
```

<a name="testing"></a>

## Testing

Run following command to prepare testing environment.

```bash
composer prepare-test
```

Run following command to run tests.

```bash
composer test
```

<a name="changelog"></a>

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

<a name="credits"></a>

## Credits

-   [Yusuf Kaya](https://github.com/ysfkaya)
-   [All Contributors](https://github.com/ysfkaya/filament-phone-input/graphs/contributors)

<a name="license"></a>

## License

The MIT License (MIT). Please see [License File](https://github.com/ysfkaya/filament-phone-input/blob/main/LICENCE.md) for more information.
