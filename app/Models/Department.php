<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasUlids, SoftDeletes;

    protected string $ULID_PREFIX = 'dep_';

    protected $fillable = ['name'];

    protected $keyType = 'string';

    public $incrementing = false;  

    public function roles() {
        return $this->hasMany(Role::class);
    }
}