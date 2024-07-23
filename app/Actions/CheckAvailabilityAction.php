<?php

namespace App\Actions;

use App\Http\Resources\TableResource;
use App\Repositories\ITableRepository;

class CheckAvailabilityAction implements ICheckAvailabilityAction
{
    public function __construct(protected ITableRepository $tableRepository)
    {
    }

    public function handle(array $request): ?TableResource
    {
        $table_id = $request['table_id'];
        $fromTime = $request['from_time'];
        $toTime = $request['to_time'];
        $capacity = $request['capacity'];
        $availableTable = $this->tableRepository->getAvailableTable($table_id, $fromTime, $toTime, $capacity);
        return $availableTable ? TableResource::make($availableTable) : null;
    }
}
