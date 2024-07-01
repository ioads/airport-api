<?php

use App\Http\Controllers\AirportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('airports', AirportController::class);
    Route::resource('flights', FlightController::class)->only('index', 'store', 'update', 'destroy');
    Route::resource('tickets', TicketController::class)->only('store', 'update', 'destroy');
    Route::get('flights/passengers/{flightId}', [FlightController::class, 'passengers']);
    Route::post('tickets/cancel', [TicketController::class, 'cancel']);
});

Route::get('/tickets', [TicketController::class, 'index']);
Route::post('/tickets/buy', [TicketController::class, 'buy']);
Route::get('/tickets/buyer/{cpf}', [TicketController::class, 'ticketsByCpf']);
Route::get('/tickets/voucher/{cpf}/{flightId}', [TicketController::class, 'voucher']);
Route::get('/tickets/baggage/{ticketCode}', [TicketController::class, 'baggage']);