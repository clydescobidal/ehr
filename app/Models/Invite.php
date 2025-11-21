<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasUlids;

    protected string $ULID_PREFIX = 'dep_';

    protected $keyType = 'string';

    public $incrementing = false;  

    protected $fillable = [
        'tenant_id',
        'role_id',
        'email',
        'token'
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
