# Changelog

All notable changes to `filament-phone-input` will be documented in this file

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
