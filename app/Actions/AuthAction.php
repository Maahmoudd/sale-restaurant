<?php

namespace App\Actions;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthAction implements IAuthAction
{
    public function handle(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('ApiToken')->plainTextToken;
            return ['user' => UserResource::make($user), 'token' => $token, 'type' => 'Bearer'];
        }
        return null;
    }
}
