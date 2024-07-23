<?php

namespace App\Http\Controllers\Api;

use App\Actions\IOrderAction;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends ApiBaseController
{
    public function __construct(protected IOrderAction $orderAction)
    {
    }

    public function __invoke(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderAction->handle($request->validated());
        return $order ? $this->respondCreated($order) : $this->respondFail('Order Failed');
    }
}
