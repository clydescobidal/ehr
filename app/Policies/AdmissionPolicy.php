<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\User;

class AdmissionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function createAdmission(User $user): bool
    {
        $roles = $user->getRolesOnTenant(tenant());

        return in_array(Roles::DOCTOR->value, $roles) || in_array(Roles::NURSE->value, $roles);
    }
}
