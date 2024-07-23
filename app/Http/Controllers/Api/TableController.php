<?php

namespace App\Http\Controllers\Api;

use App\Actions\ICheckAvailabilityAction;
use App\Http\Requests\CheckAvailabilityRequest;
use Illuminate\Http\JsonResponse;

class TableController extends ApiBaseController
{

    public function __construct(protected ICheckAvailabilityAction $checkAvailabilityAction)
    {
    }

    public function __invoke(CheckAvailabilityRequest $request): JsonResponse
    {
        $availableTable = $this->checkAvailabilityAction->handle($request->validated());
        return $availableTable ? $this->respondSuccess($availableTable) : $this->respondError('Table Not available');
    }
}
