<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountsController;
use App\Http\Controllers\EventsController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('reset', [AccountsController::class, 'reset']);
Route::post('event', [EventsController::class, 'event']);
Route::get('balance/{account_id?}', [AccountsController::class, 'balance']);