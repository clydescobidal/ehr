<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use \Spatie\Permission\Models\Permission as BasePermission;

class Permission extends BasePermission
{
    use HasUlids;

    protected string $ULID_PREFIX = 'per_';
}