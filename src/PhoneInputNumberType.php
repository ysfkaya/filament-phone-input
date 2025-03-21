<?php

namespace Ysfkaya\FilamentPhoneInput;

use libphonenumber\PhoneNumberFormat;

enum PhoneInputNumberType: string
{
    case E164 = 'E164';
    case INTERNATIONAL = 'INTERNATIONAL';
    case NATIONAL = 'NATIONAL';
    case RFC3966 = 'RFC3966';

   public function toLibPhoneNumberFormat(): int
{
    $format = match ($this) {
        self::E164 => PhoneNumberFormat::E164,
        self::INTERNATIONAL => PhoneNumberFormat::INTERNATIONAL,
        self::NATIONAL => PhoneNumberFormat::NATIONAL,
        self::RFC3966 => PhoneNumberFormat::RFC3966,
    };
    
    // Handle both enum and integer constant cases
    return enum_exists(PhoneNumberFormat::class) ? $format->value : $format;
}
}
