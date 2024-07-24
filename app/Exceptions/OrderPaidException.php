<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderPaidException extends Exception
{
    public function render(Request $request): Response
    {
        return response(['message' => 'Order already paid'], Response::HTTP_CONFLICT);
    }
}
