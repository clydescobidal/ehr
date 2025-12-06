<?php

namespace App\Enums;

enum MaritalStatus: string
{
    case SINGLE = 'SINGLE';
    case MARRIED = 'MARRIED';
    case DIVORCED = 'DIVORCED';
    case WIDOWED = 'WIDOWED';
    case SEPARATED = 'SEPARATED';
    case DOMESTIC_PARTNER = 'DOMESTIC_PARTNER';
    case UNMARRIED = 'UNMARRIED';
    case UNKNOWN = 'UNKNOWN';
    case DECLINED = 'DECLINED';
}