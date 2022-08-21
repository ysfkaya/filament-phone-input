<?php

namespace Ysfkaya\FilamentPhoneInput;

enum PhoneInputNumberType: string
{
    case E164 = 'E164';
    case INTERNATIONAL = 'INTERNATIONAL';
    case NATIONAL = 'NATIONAL';
    case RFC3966 = 'RFC3966';
}
