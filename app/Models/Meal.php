<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
