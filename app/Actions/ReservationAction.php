<?php

namespace App\Actions;

use App\Http\Resources\ReservationResource;
use App\Repositories\IReservationRepository;
use App\Repositories\IWaitingListRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ReservationAction implements IReservationAction
{
    public function __construct(
        protected IReservationRepository $reservationRepository,
        protected IWaitingListRepository $waitingListRepository
    )
    {
    }

    public function handle(array $request)
    {
        $existingReservation = $this->reservationRepository->getExistingReservation(
            $request['table_id'],
            $request['from_time'],
            $request['to_time']
        );
        $existingWaitingList = $this->waitingListRepository->getExistingWaitingList(
            $request['table_id'],
            $request['from_time'],
            $request['to_time']
        );

        if ($existingReservation) {
            if ($existingWaitingList) {
                return [
                    'message' => 'No Room on this table',
                    'data' => [ReservationResource::make($existingWaitingList)],
                    'code' => Response::HTTP_INTERNAL_SERVER_ERROR
                ];
            }
            $waitingList = $this->waitingListRepository->create($request);
            return [
                'message' => 'Table already reserved at this time and you are added to the waiting list',
                'data' => [ReservationResource::make($waitingList)],
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR
            ];
        }
        DB::beginTransaction();

        try {
            $reservation = $this->reservationRepository->createReservation($request);
            DB::commit();

            return [
                'message' => 'Reservation created successfully.',
                'data' => [ReservationResource::make($reservation)],
                'code' => Response::HTTP_CREATED
            ];
        } catch (\Exception $e) {
            DB::rollBack();

            return [
                'message' => 'Transaction failed. Rollback performed.',
                'data' => [],
                'code' => Response::HTTP_EXPECTATION_FAILED
            ];
        }
    }
}
