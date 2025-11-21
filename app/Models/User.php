<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasUlids, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;  

    protected string $ULID_PREFIX = 'usr_';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'last_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    
    public function tenants() {
        return $this->hasMany(TenantUser::class);
    }

    public function getTenantRolesAttribute() {
        $tenantRoles = [];
        $tenant = tenant();
        
        if ($tenant) {
            $tenantRoles = $this->tenants->firstWhere('tenant_id', $tenant->id)?->roles;
        }

        return $tenantRoles;
    }

    public function getRolesOnTenant(Tenant $tenant) {
        $roles = [];

        $tenant = $this->tenants->firstWhere('tenant_id', $tenant->id);
        if ($tenant) {
            $roles = $tenant->roles->pluck('name')->toArray();
        }
        
        return $roles;
    }
}
