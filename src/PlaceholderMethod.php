<?php

namespace Ysfkaya\FilamentPhoneInput;

enum PlaceholderMethod: string
{
    case POLITE = 'polite'; //applies placeholder if input doesn't have one defined
    case AGGRESSIVE = 'aggresive'; //replaces any existing placeholder
    case OFF = 'off';
}
