<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CheckoutRequest;
use App\Strategies\IPaymentStrategy;

class CheckoutController extends ApiBaseController
{
    public function __construct(protected IPaymentStrategy $paymentStrategy)
    {
    }

    public function __invoke(CheckoutRequest $request)
    {
        $checkout = $this->paymentStrategy->pay($request->validated());
        return $this->respondCreated($checkout);
    }
}
