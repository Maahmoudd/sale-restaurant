<?php

namespace App\Actions;

use App\Http\Requests\LoginRequest;

interface IAuthAction
{
    public function handle(LoginRequest $request);
}
