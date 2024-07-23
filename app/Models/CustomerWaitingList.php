<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerWaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'table_id',
        'to_time',
        'from_time',
    ];

}
