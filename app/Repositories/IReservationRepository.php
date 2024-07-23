<?php

namespace App\Repositories;

interface IReservationRepository
{
    public function getExistingReservation($tableId,$fromTime, $toTime);
    public function createReservation(array $request);
}
