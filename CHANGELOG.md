# Changelog

All notable changes to `filament-phone-input` will be documented in this file

## v3.2.1 - 2025-06-24

### What's Changed

- Compatibility issues

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.2.0...v3.2.1

## v3.2.0 - 2025-06-23

### What's Changed

* Improves and compatibility with both `propaganistas/laravel-phone`'s ^5.0 and ^6.0 versions by @ysfkaya in https://github.com/ysfkaya/filament-phone-input/pull/90

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.11...v3.2.0

## v3.1.11 - 2025-06-18

### What's Changed

- Fixed unmatched number format in `propaganistas/laravel-phone`

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.10...v3.1.11

## v3.1.10 - 2025-06-16

### What's Changed

* add support for propaganistas/laravel-phone v6.0 by @SeyamMs in https://github.com/ysfkaya/filament-phone-input/pull/83

### New Contributors

* @SeyamMs made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/83

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.9...v3.1.10

## 3.1.9 - 2025-05-28

### What's Changed

* fix: replace the old flag of Syria with the new  official flag by @ARMBouhali in https://github.com/ysfkaya/filament-phone-input/pull/81

### New Contributors

* @ARMBouhali made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/81

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.8...v3.1.9

## v2.3.8 - 2025-04-25

### What's Changed

- Fixes libphonenumber enum issue

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.7...v2.3.8

## 3.1.8 - 2025-03-23

### What's Changed

* Update PhoneInputNumberType.php by @mehmethamza in https://github.com/ysfkaya/filament-phone-input/pull/72

### New Contributors

* @mehmethamza made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/72

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.7...v3.1.8

## 3.1.7 - 2025-03-10

### What's Changed

* Resolve critical vulnerability GHSA-vjh7-7g9h-fjfh by @Orrison in https://github.com/ysfkaya/filament-phone-input/pull/69

### New Contributors

* @Orrison made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/69

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.6...v2.4.8

## v2.4.8 - 2025-03-10

### What's Changed

* Resolve critical vulnerability GHSA-vjh7-7g9h-fjfh by @Orrison in https://github.com/ysfkaya/filament-phone-input/pull/69

### New Contributors

* @Orrison made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/69

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.6...v2.4.8

## v3.1.6 - 2025-02-22

### What's Changed

* Fix Alpine directive from 'ax-' to 'x-' in phone input view by @smiliyas in https://github.com/ysfkaya/filament-phone-input/pull/67

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.5...v3.1.6

## 3.1.5 - 2025-02-10

### What's Changed

- Fixed an issue where the associative values of `PhoneEntry` and `PhoneColumn` components were not showing up.

## 3.1.4 - 2024-12-17

### What's Changed

* Fixes `Js` class implementation issue in `phone-input.blade.php` by @elegasoft in https://github.com/ysfkaya/filament-phone-input/pull/60

### New Contributors

* @elegasoft made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/60

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.3...v3.1.4

## 3.1.3 - 2024-12-14

### What's New

- Fixed an error clearing the input value when the state value is filled as empty.
- Bump `intl-tel-input` version to `25.2.0`

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.2...v3.1.3

## 3.1.2 - 2024-10-31

### What's Changed

- Disabling country selection when input set disabled

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.1...v3.1.2

## 3.1.1 - 2024-10-29

### What's Changed

- Fixed an issue regarding whether the input in the reactive state is disabled or not
- Bump intl-tel-input version to `24.6.0`

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.1.0...v3.1.1

## 3.1.0 - 2024-09-04

### What's Changed

- Fixes #49 and upgraded latest version of the `intl-tel-input`

> [!IMPORTANT]
The flag images have been updated in the latest version of the `intl-tel-input` package. So you need to run

```bash
php artisan vendor:publish --tag="filament-phone-input-assets" --force
















```
Otherwise the flag images may not be reflected correctly.

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.0.2...v3.1.0

## v3.0.2 - 2024-08-22

### What's Changed

* Fix RTL Phone Number Display by @emargareten in https://github.com/ysfkaya/filament-phone-input/pull/48

### New Contributors

* @emargareten made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/48

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.0.1...v3.0.2

## v2.3.7 - 2024-08-14

### What's Changed

* Fixed path to `use PhoneInputNumberType;` by @snipe in https://github.com/ysfkaya/filament-phone-input/pull/43
* Update README.md by @marcos-aparicio in https://github.com/ysfkaya/filament-phone-input/pull/44
* fix async alpine not loading reliably in spa mode by @smiliyas in https://github.com/ysfkaya/filament-phone-input/pull/47

### New Contributors

* @snipe made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/43
* @marcos-aparicio made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/44
* @smiliyas made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/47

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.6...v2.3.7

## v3.0.1 - 2024-08-14

### What's Changed

* fix async alpine not loading reliably in spa mode by @smiliyas in https://github.com/ysfkaya/filament-phone-input/pull/47

### New Contributors

* @smiliyas made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/47

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v3.0.0...v3.0.1

## v3.0.0 - 2024-08-10

### What's Changed

* Upgraded latest version of `intl-tel-input`
* Fixed path to `use PhoneInputNumberType;` by @snipe in https://github.com/ysfkaya/filament-phone-input/pull/43
* Update README.md by @marcos-aparicio in https://github.com/ysfkaya/filament-phone-input/pull/44
* Version 3 by @ysfkaya in https://github.com/ysfkaya/filament-phone-input/pull/45

### New Contributors

* @snipe made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/43
* @marcos-aparicio made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/44

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.6...v3.0.0

## v2.3.6 - 2024-05-24

### What's Changed

- Fixed affix actions #42

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.5...v2.3.6

## v2.3.5 - 2024-03-21

### What's Changed

- Fixed an issue triggering `unsavedChangeAlerts` event. #38

## 2.3.4 - 2024-03-12

### What's Changed

* Update README.md by @nathanpelton in https://github.com/ysfkaya/filament-phone-input/pull/37
* Uptade dependecy version of `spatie/laravel-package-tools`

### New Contributors

* @nathanpelton made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/37

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.3...v2.3.4

## 2.3.3 - 2024-02-24

### What's Changed

* allowing array as value for type parameter in PhoneInput@validateFor by @Carnicero90 in https://github.com/ysfkaya/filament-phone-input/pull/35

### New Contributors

* @Carnicero90 made their first contribution in https://github.com/ysfkaya/filament-phone-input/pull/35

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.2...v2.3.3

## 2.3.2 - 2024-02-03

### What's Changed

- Fixed infinite recursion issue while using country state path.

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.1...v2.3.2

## v2.3.1 - 2024-02-03

### What's Changed

- Fixed an issue with instant detection of state change

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.3.0...v2.3.1

## 2.3.0 - 2024-02-03

### What's Changed

- Updated to the latest version of the `intl-tel-input` library.
- Renamed `separateDialCode` method to `showSelectedDialCode`. The `separateDialCode` method will be removed in a major version update.
- Added `autoInsertDialCode` method. For details, see [here](https://github.com/jackocnr/intl-tel-input#autoInsertDialCode).
- Introduced a search input for countries with the new version. To hide this, the `countrySearch` method has been added.
- Added `formatAsYouType` method.
- This extension now publishes and utilizes flag icons available in the `intl-tel-input` library. Reading files via routes will be removed in the next major version.
- Renamed `PhoneInputColumn` to `PhoneColumn`. This class will be removed in a major version update.
- Added `PhoneEntry` class for use in InfoList.

**Full Changelog**: https://github.com/ysfkaya/filament-phone-input/compare/v2.2.2...v2.3.0

## 2.2.2 - 2024-01-24

### What's Changed

- Accept an array to the `validatedCountry` property by @adesege #32

## 2.2.1 - 2024-01-06

### What's Changed

- Fixed `validateFor` method by using `int` instead of `string` in `$type` parameter

## 2.2.0 - 2023-12-12

### What's Changed

- Added `showFlags` option
- Added `useFullscreenPopup`option

## 2.1.2 - 2023-11-21

### What's Changed

- Fixed form field ax-load issue on spa-mode by @ArtMin96 #26

## 2.1.1 - 2023-10-17

### What's Changed

- Added `static` return type by @akunbeben #23

## 2.1.0 - 2023-10-13

### What's Changed

- Fixed error in phone number parse. #21
- Added `defaultCountry` method

## 2.0.0 - 2023-08-19

This version brings compatibility with Filament v3 and introduces a range of new features and improvements:

### What's New

- Full compatibility with Filament v3.
- Comprehensive unit tests.
- Thorough browser tests.
- Separation of country area code into a dedicated state.
- Introduction of a class for table building.
- Implementation of a customizable validation method.
- Extended usage beyond Filament.
- Updated documentation.
- Updated intl-tel-input version to `v18.2.1`

## 1.3.3 - 2023-07-20

### What's Changed

- Fix #16

## 1.3.2 - 2023-03-02

### What's Changed

- Fixes previous release

## 1.3.1 - 2023-03-02

### What's Changed

- Adds `IntlTelInputSelectedCountryCookie` property to automatically set country in cookie.

## 1.3.0 - 2023-02-15

### What's Changed

- Updated the dependencies for support Laravel 10

## 1.2.1 - 2023-02-02

### What's Changed

- Fixed when entering value at the state watching

## 1.2.0 - 2022-11-23

### What's Changed

- Support both lazy and debounce by @tanthammar in #8

## 1.1.3 - 2022-11-09

### What's Changed

- Fixed an issue where the state did not change when updating the value. #7

## 1.1.2 - 2022-10-22

### What's Changed

- Fixed an issue where overflow of input dropdown. #3

## 1.1.1 - 2022-09-24

### What's Changed

- Correction of `js` path in ServiceProvider.

## 1.1.0 - 2022-09-23

### What's Changed

- Fixed issue with white background color where in dark mode. #4

## 1.0.1 - 2022-08-21

- Adds images folder

## 1.0.0 - 2022-08-21

- initial release
