<?php

namespace Ysfkaya\FilamentPhoneInput;

use libphonenumber\PhoneNumberFormat;
use Propaganistas\LaravelPhone\PhoneNumber;

enum PhoneInputNumberType: string
{
    case E164 = 'E164';
    case INTERNATIONAL = 'INTERNATIONAL';
    case NATIONAL = 'NATIONAL';
    case RFC3966 = 'RFC3966';

    public function toLibPhoneNumberFormat(): int | PhoneNumberFormat
    {
        $format = match ($this) {
            self::E164 => PhoneNumberFormat::E164,
            self::INTERNATIONAL => PhoneNumberFormat::INTERNATIONAL,
            self::NATIONAL => PhoneNumberFormat::NATIONAL,
            self::RFC3966 => PhoneNumberFormat::RFC3966,
        };

        // @phpstan-ignore-next-line
        if (class_exists(PhoneNumber::class) && method_exists(PhoneNumber::class, 'normalizeFormat')) {
            return PhoneNumber::normalizeFormat($format);
        }

        return enum_exists(PhoneNumberFormat::class) ? (function_exists('enum_value') ? enum_value($format) : $format->value) : $format;
    }
}
