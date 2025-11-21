<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTenantRequest;
use App\Http\Requests\InviteTenantUserRequest;
use App\Models\Invite;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\TenantUser;
use Auth;
use Str;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends Controller
{
    public function create(CreateTenantRequest $request) {
        $user = Auth::user();
        $name = $request->input('name');
        $dbName = $this->generateDatabaseName($name);

        $tenant = Tenant::create([
            'name' => $name,
            'tenancy_db_name' => $dbName
        ]);

        $tenantUser = TenantUser::create([
            'user_id' => $user->id,
            'tenant_id' => $tenant->id
        ]);

        $tenantUser->assignRole('owner');

        return $tenant;
    }

    protected function generateDatabaseName(string $name) {
        $databaseName = Str::snake($name);
        $prefixedDatabaseName = "tenant_$databaseName";
        $prefix = 0;

        while (true) {
            if (Tenant::where('data->tenancy_db_name', $prefixedDatabaseName)->doesntExist()) {
                break;
            }

            $prefix++;
            $prefixedDatabaseName = "tenant_{$databaseName}_{$prefix}";
        }

        return $prefixedDatabaseName;
    }

    public function inviteUser(Tenant $tenant, InviteTenantUserRequest $request) {
        $tenantUserExists = $tenant->tenantUsers()->where(function($query) use ($request) {
            $query->whereHas('user', function($query) use ($request) {
                $query->where('email', $request->input('email'));
            });
        })->exists();

        if ($tenantUserExists) {
            abort(Response::HTTP_CONFLICT, 'TENANT_USER_ALREADY_EXISTS');
        }

        tenancy()->initialize($tenant);
        $tenantRole = Role::find($request->input('role_id'));
        if (! $tenantRole) {
            abort(Response::HTTP_UNPROCESSABLE_ENTITY, 'INVALID_TENANT_ROLE');
        }
        tenancy()->end();

        $invite = Invite::firstOrCreate(
            [
                'tenant_id' => $tenant->id,
                'role_id' => $tenantRole->id,
                'email' => $request->input('email'),
            ], 
            [
                'token' => Str::random(32)
            ]
        );

        return response()->noContent();
    }
}
