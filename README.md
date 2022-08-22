# Filament Phone Input

<p align="center"><img src="/screenshots/input.png" alt="Filament Phone Input"></p>

This package provides a phone input component for [Laravel Filament](https://filamentadmin.com/). It uses [International Telephone Input](https://github.com/jackocnr/intl-tel-input) to provide a dropdown of countries and flags.

## Installation

You can install the package via composer:

```bash
composer require ysfkaya/filament-phone-input
```

## Usage

```php
use Filament\Forms;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

  //...
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
```

You may set the display format of the phone number by passing a format string to the `displayNumberFormat` method. The default format is `NATIONAL`. That means the phone number will be displayed in the format of the selected country.

> Available formats are; 

- PhoneInputNumberFormat::E164
- PhoneInputNumberFormat::INTERNATIONAL
- PhoneInputNumberFormat::NATIONAL
- PhoneInputNumberFormat::RFC3966

```php
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

PhoneInput::make('phone')
    ->displayNumberFormat(PhoneInputNumberFormat::E164),
```

<p align="left"><img src="/screenshots/display-number-format.png" alt="Filament Phone Input"></p>

You may set the input value type by passing a type string to the `inputNumberFormat` method. The default type is `E164`. That means the phone number will be saved in the format of the selected country to the **database**.

```php
use Ysfkaya\FilamentPhoneInput\PhoneInputNumberType;

PhoneInput::make('phone')
    ->inputNumberFormat(PhoneInputNumberType::NATIONAL),
```

You may set the focus input type by passing a type string to the `focusInputType` method. The default value is `false`.

```php
use Ysfkaya\FilamentPhoneInput\PhoneInputFocusInputType;

PhoneInput::make('phone')
    ->focusInputType(PhoneInputFocusInputType::E164),
```

<p align="left"><img src="/screenshots/focus-input-type.gif" alt="Filament Phone Input"></p>

You may disable the dropdown by using the `disallowDropdown` method:

```php
PhoneInput::make('phone')
    ->disallowDropdown(),
```

<p align="left"><img src="/screenshots/disallowed-dropdown.png" alt="Filament Phone Input"></p>

You may set the auto placeholder type by using the `autoPlaceholder` method:

```php
PhoneInput::make('phone')
    ->autoPlaceholder('polite'), // default is 'aggressive'
```

You may set the additional classes to add to the parent div by using the `customContainer` method:

```php
PhoneInput::make('phone')
    ->customContainer('w-full'),
```

You may set the custom placeholder by using the `customPlaceholder` method:

```php
PhoneInput::make('phone')
    ->customPlaceholder('jsMethodName'),
```

And you should add a js method to your blade file like this:

```js
window.jsMethodName = function(selectedCountryPlaceholder, selectedCountryData) {
    return 'Custom Placeholder';
}
```

You may set the exclude countries by using the `excludeCountries` method:

```php
PhoneInput::make('phone')
    ->excludeCountries(['us', 'gb']),
```

You may set the initial country by using the `initialCountry` method:

```php
PhoneInput::make('phone')
    ->initialCountry('us'),
```

You may set the only countries by using the `onlyCountries` method:

```php
PhoneInput::make('phone')
    ->onlyCountries(['tr','us', 'gb']),
```

<p align="left"><img src="/screenshots/only-countries.png" alt="Filament Phone Input"></p>

You may set the format on display by using the `formatOnDisplay` method:

```php
PhoneInput::make('phone')
    ->formatOnDisplay(false),
```

You may set the geoIp lookup by using the `geoIpLookup` method:

```php
PhoneInput::make('phone')
    ->geoIpLookup('jsMethodName'),
```

And you should add a js method to your blade file like this:

```js
window.jsMethodName = function(callback) {
    $.get('http://ipinfo.io', function() {}, "jsonp").always(function(resp) {
        var countryCode = (resp && resp.country) ? resp.country : "";
        callback(countryCode);
    });
}
```

You may set the placeholder number type by using the `placeholderNumberType` method:

```php
PhoneInput::make('phone')
    ->placeholderNumberType('FIXED_LINE'),
```

You may set the preferred countries by using the `preferredCountries` method:

```php
PhoneInput::make('phone')
    ->preferredCountries(['tr','us', 'gb']),
```

You may set the separate dial code by using the `separateDialCode` method:

```php
PhoneInput::make('phone')
    ->separateDialCode(true),
```

You can find the more documentation for the package [here](https://intl-tel-input.com/)


<a name="testing"></a>

## Testing

```bash
composer test
```

<a name="changelog"></a>

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

<a name="credits"></a>

## Credits

-   [Yusuf Kaya](https://github.com/ysfkaya)
-   [All Contributors](../../contributors)

<a name="license"></a>

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
