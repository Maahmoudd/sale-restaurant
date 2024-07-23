<?php

namespace App\Http\Controllers\Api;

use App\Actions\ICheckAvailabilityAction;
use App\Http\Requests\CheckAvailabilityRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TableController extends ApiBaseController
{

    public function __construct(protected ICheckAvailabilityAction $checkAvailabilityAction)
    {
    }

    public function __invoke(CheckAvailabilityRequest $request): JsonResponse
    {
        $availableTable = $this->checkAvailabilityAction->handle($request->validated());
        return $availableTable ? $this->respondSuccess($availableTable) : $this->respondError('Table Not available', message: 'Reserved at this time', status: Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
