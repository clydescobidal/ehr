<?php

namespace App\Enums;
enum GenderIdentity: string
{
    case MALE = 'MALE';
    case FEMALE = 'FEMALE';
    case TRANSGENDER_MALE = 'TRANSGENDER_MALE';
    case TRANSGENDER_FEMALE = 'TRANSGENDER_FEMALE';
    case NON_BINARY = 'NON_BINARY';
    case GENDERQUEER = 'GENDERQUEER';
    case GENDERFLUID = 'GENDERFLUID';
    case AGENDER = 'AGENDER';
    case TWO_SPIRIT = 'TWO_SPIRIT';
    case OTHER = 'OTHER';
    case PREFER_NOT_TO_SAY = 'PREFER_NOT_TO_SAY';
    case UNKNOWN = 'UNKNOWN';

}