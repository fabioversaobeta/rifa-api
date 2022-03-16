<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('createTicket', [TicketController::class, 'create']);
Route::get('getQuantities', [TicketController::class, 'quantities']);
Route::get('getRandomTicket', [TicketController::class, 'randomTIcket']);