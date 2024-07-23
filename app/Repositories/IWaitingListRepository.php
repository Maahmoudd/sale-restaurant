<?php

namespace App\Repositories;

interface IWaitingListRepository
{
    public function create(array $request);
    public function getExistingWaitingList($tableId, $fromTime, $toTime);
}
