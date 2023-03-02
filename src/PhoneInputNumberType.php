<?php

namespace Ysfkaya\FilamentPhoneInput;

enum PhoneInputNumberType: string
{
    case FIXED_LINE = "FIXED_LINE";
    case MOBILE = "MOBILE";
    case FIXED_LINE_OR_MOBILE = "FIXED_LINE_OR_MOBILE";
    case TOLL_FREE = "TOLL_FREE";
    case PREMIUM_RATE = "PREMIUM_RATE";
    case SHARED_COST = "SHARED_COST";
    case VOIP = "VOIP";
    case PERSONAL_NUMBER = "PERSONAL_NUMBER";
    case PAGER = "PAGER";
    case UAN = "UAN";
    case VOICEMAIL = "VOICEMAIL";
    case UNKNOWN = "UNKNOWN";
}
