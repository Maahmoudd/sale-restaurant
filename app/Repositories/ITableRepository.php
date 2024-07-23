<?php

namespace App\Repositories;


interface ITableRepository
{
    public function getAvailableTable($table_id, $fromTime, $toTime, $capacity);
}
