<?php

namespace App\Enums;

enum AdmissionStatus: string
{
    case ACTIVE = 'ACTIVE';
    case DISCHARGED = 'DISCHARGED';
}