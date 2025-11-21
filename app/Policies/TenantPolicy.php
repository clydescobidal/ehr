<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\Tenant;
use App\Models\User;
use Arr;

class TenantPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function inviteUser(User $user, Tenant $tenant) {
        $roles = $user->getRolesOnTenant($tenant);

        return in_array(Roles::OWNER->value, $roles) || in_array(Roles::ADMINISTRATOR->value, $roles);
    }
}
