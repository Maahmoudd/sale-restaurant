<?php

namespace App\Repositories;

use App\Models\Table;

class TableRepository implements ITableRepository
{
    public function getAvailableTable($table_id, $fromTime, $toTime, $capacity)
    {
        return Table::query()
            ->where('capacity', '>=', $capacity)
            ->whereDoesntHave('reservations', function ($query) use ($fromTime, $toTime) {
                $query->where('from_time', '<', $fromTime)
                    ->where('to_time', '>', $toTime);
            })
            ->find($table_id);
    }
}
