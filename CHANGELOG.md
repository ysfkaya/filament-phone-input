# Changelog

All notable changes to `filament-phone-input` will be documented in this file

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
