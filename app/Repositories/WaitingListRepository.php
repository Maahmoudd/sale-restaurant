<?php

namespace App\Repositories;

use App\Models\CustomerWaitingList;

class WaitingListRepository implements IWaitingListRepository
{
    public function create(array $request)
    {
        return CustomerWaitingList::create($request);
    }
    public function getExistingWaitingList($tableId, $fromTime, $toTime)
    {
        return CustomerWaitingList::query()
            ->where('table_id', $tableId)
            ->where(function ($query) use ($fromTime, $toTime) {
                $query->where(function ($q) use ($fromTime, $toTime) {
                    $q->where('from_time', '<', $toTime)
                        ->where('to_time', '>', $fromTime);
                });
            })
            ->first();
    }
}
