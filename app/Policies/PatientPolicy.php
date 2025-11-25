<?php

namespace App\Policies;

use App\Enums\Roles;
use App\Models\AppModelsPatient;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PatientPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function createPatient(User $user): bool
    {
        $roles = $user->getRolesOnTenant(tenant());

        return in_array(Roles::DOCTOR->value, $roles) || in_array(Roles::NURSE->value, $roles);
    }
}
