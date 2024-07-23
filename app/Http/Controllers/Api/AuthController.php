<?php

namespace App\Http\Controllers\Api;

use App\Actions\IAuthAction;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends ApiBaseController
{
    public function __construct(protected IAuthAction $authAction)
    {
    }

    public function __invoke(LoginRequest $request): JsonResponse
    {
        $authUser = $this->authAction->handle($request);
        return $authUser ? $this->respondSuccess($authUser) : $this->respondError('Invalid credentials');
    }
}