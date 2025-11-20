<?php

namespace App\Models;

use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class TenantUser extends Model
{
    use HasRoles, HasUlids;

    protected $guard_name = 'sanctum';

    protected string $ULID_PREFIX = 'tnu_';

    protected $keyType = 'string';
    
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'tenant_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tenant() {
        return $this->belongsTo(Tenant::class);
    }
}
