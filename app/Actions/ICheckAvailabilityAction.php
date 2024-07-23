<?php

namespace App\Actions;


use App\Http\Resources\TableResource;

interface ICheckAvailabilityAction
{
    public function handle(array $request): ?TableResource;
}
