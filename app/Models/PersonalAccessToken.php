<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use \Laravel\Sanctum\PersonalAccessToken as BasePersonalAccessToken;

class PersonalAccessToken extends BasePersonalAccessToken
{
    use HasUlids;

    protected $keyType = 'string';

    public $incrementing = false;  

    protected string $ULID_PREFIX = 'pat_';

    protected $connection = 'pgsql';
}
