<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('tickets', TicketController::class)->only('index', 'store', 'update', 'destroy');
    Route::post('/tickets/buy', [TicketController::class, 'buy']);
});