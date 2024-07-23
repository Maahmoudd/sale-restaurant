<?php

namespace App\Strategies;

interface IPaymentStrategy
{
    public function pay(array $data);
}
