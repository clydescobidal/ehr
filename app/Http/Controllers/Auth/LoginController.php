<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\TokenResource;
use App\Models\User;
use Hash;

class LoginController extends Controller
{
    public function login(LoginRequest $request) {
        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            abort(422, "INVALID_CREDENTIALS");
        }
        
        if (! Hash::check($request->input('password'), $user->password)) {
            abort(422, "INVALID_CREDENTIALS");
        }

        $tokenName = sprintf("%s %s", $request->header('User-Agent'), $request->ip());
        $token = $user->createToken($tokenName);

        return TokenResource::make($token->plainTextToken);
    }
}
