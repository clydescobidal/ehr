<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use \Spatie\Permission\Models\Role as BaseRole;

class Role extends BaseRole
{
    use HasUlids;

    protected string $ULID_PREFIX = 'rol_';

    protected $hidden = ['pivot'];
}