<?php

namespace App\Enums;

enum Roles: string
{
    case OWNER = 'owner';
    case ADMINISTRATOR = 'administrator';
    case DOCTOR = 'doctor';
    case NURSE = 'nurse';
}
