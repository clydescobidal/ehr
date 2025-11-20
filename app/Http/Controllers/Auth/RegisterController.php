<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\TokenResource;
use App\Models\User;
use Symfony\Component\Uid\Ulid;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request) {
        $user = User::create($request->validated());

        $tokenName = sprintf("%s %s", $request->header('User-Agent'), $request->ip());
        $token = $user->createToken($tokenName);

        return TokenResource::make(['token' => $token->plainTextToken]);
    }
}
