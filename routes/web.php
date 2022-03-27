<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('v1/createTicket', [TicketController::class, 'create']);
Route::get('v1/getQuantities', [TicketController::class, 'quantities']);
Route::get('v1/getRandomTicket', [TicketController::class, 'randomTIcket']);
Route::get('v1/reset', [TicketController::class, 'reset']);