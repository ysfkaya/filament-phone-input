<?php

namespace Ysfkaya\FilamentPhoneInput;

enum PhoneInputNumberFormat: string
{
    case E164 = 'E164'; //+46805376635
    case INTERNATIONAL = 'INTERNATIONAL'; //+46 8 053 766 35
    case NATIONAL = 'NATIONAL'; //08-053 766 35
    case RFC3966 = 'RFC3966'; //tel:+46-8-053-766-35
}
