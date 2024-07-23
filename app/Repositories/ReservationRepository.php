<?php

namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository implements IReservationRepository
{
    public function getExistingReservation($tableId, $fromTime, $toTime)
    {
        return Reservation::query()
            ->where('table_id', $tableId)
            ->where(function ($query) use ($fromTime, $toTime) {
                $query->where(function ($q) use ($fromTime, $toTime) {
                    $q->where('from_time', '<', $toTime)
                        ->where('to_time', '>', $fromTime);
                });
            })
            ->first();
    }

    public function createReservation(array $request)
    {
        return Reservation::create($request);
    }
}
