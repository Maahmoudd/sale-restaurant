<?php

namespace App\Http\Controllers\Api;

use App\Actions\IReservationAction;
use App\Http\Requests\ReservationRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends ApiBaseController
{
    public function __construct(protected IReservationAction $reservationAction)
    {
    }

    public function __invoke(ReservationRequest $request): JsonResponse
    {
        $reservation = $this->reservationAction->handle($request->validated());
        if ($reservation['code'] === Response::HTTP_CREATED) {
            return $this->respondCreated($reservation['data'], $reservation['message']);
        }
        return $this->respondFail($reservation['data'], $reservation['message'], $reservation['code']);
    }
}
