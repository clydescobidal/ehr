<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\Tenant;
use App\Models\User;

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
        $rolesOnTenant = $user->getRolesOnTenant($tenant);

        return in_array(Roles::OWNER->value, $rolesOnTenant) || in_array(Roles::ADMINISTRATOR->value, $rolesOnTenant);
    }
}
