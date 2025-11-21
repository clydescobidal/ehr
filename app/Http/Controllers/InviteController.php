<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteTenantUserRequest;
use App\Models\Invite;
use App\Models\Role;
use App\Models\Tenant;
use Auth;
use Str;
use Symfony\Component\HttpFoundation\Response;

class InviteController extends Controller
{
    public function create(InviteTenantUserRequest $request) {
        $tenant = Tenant::findOrFail($request->input('tenant_id'));

        if (Auth::user()->cant('inviteUser', $tenant)) {
            abort(Response::HTTP_FORBIDDEN, 'FORBIDDEN');
        }

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
                'token' => Str::random(64)
            ]
        );

        if ($invite->wasRecentlyCreated) {
            // send invite email with $invite->token
        }

        return response()->noContent();
    }
}
