<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Auth;

class UserController extends Controller
{
    public function me() {
        $user = Auth::user()->load(['tenantUsers' => function($query) {
            $query->whereHas('roles')->with('tenant', 'roles');
        }]);


        return UserResource::make($user);
    }
}
