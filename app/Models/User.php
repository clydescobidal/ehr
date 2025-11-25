<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\HasUlids;
use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\PermissionRegistrar;

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
    
    public function tenantUsers() {
        return $this->hasMany(TenantUser::class);
    }

    public function getRolesOnTenant(Tenant $tenant) {
        return $tenant
            ->tenantUsers
            ->firstWhere('user_id', $this->id)
            ->roles
            ->pluck('name')
            ->toArray();
    }

    public function getTenantUserOnTenant(Tenant $tenant): TenantUser {
        return $tenant
            ->tenantUsers
            ->firstWhere('user_id', $this->id);
    }
}
