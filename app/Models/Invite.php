<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasUlids;

    protected string $ULID_PREFIX = 'inv_';

    protected $keyType = 'string';

    public $incrementing = false;  

    protected $fillable = [
        'tenant_id',
        'role_id',
        'email',
    ];

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }
}
