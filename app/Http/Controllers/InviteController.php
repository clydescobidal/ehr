<?php

namespace App\Http\Controllers;

use App\Http\Requests\InviteTenantUserRequest;
use App\Http\Resources\InvitesListCollection;
use App\Http\Resources\InvitesListResource;
use App\Models\Invite;
use App\Models\Role;
use App\Models\Tenant;
use Auth;
use Str;
use Symfony\Component\HttpFoundation\Response;

class InviteController extends Controller
{
    public function list() {
        $user = Auth::user();
        $invites = Invite::where('email', $user->email)->get();

        return InvitesListCollection::make(resource: $invites);
    }
    
    public function create(InviteTenantUserRequest $request) {
        $tenant = Tenant::findOrFail($request->input('tenant_id'));

        if (Auth::user()->cannot('inviteUser', $tenant)) {
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

        $invite = Invite::firstOrCreate([
            'tenant_id' => $tenant->id,
            'role_id' => $request->input(key: 'role_id'),
            'email' => $request->input('email'),
        ]);

        if ($invite->wasRecentlyCreated) {
            // send invite email with $invite->token
        }

        return response()->noContent();
    }
}
