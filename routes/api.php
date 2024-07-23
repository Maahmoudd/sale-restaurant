<?php

use App\Http\Controllers\Api\{AuthController, ReservationController, TableController, MealController, OrderController, CheckoutController};
use Illuminate\Support\Facades\Route;

Route::post('/login', AuthController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/check-availability', TableController::class);
    Route::post('/reserve-table', ReservationController::class);
    Route::get('/list-menu-items', MealController::class);
    Route::post('/place-order', OrderController::class);
    Route::post('/checkout', CheckoutController::class);
});
