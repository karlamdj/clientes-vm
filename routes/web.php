<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\ClientController;
Route::post('clients/{client}/confirm-payment', [ClientController::class, 'confirmPayment'])
->name('clients.confirmPayment');

Route::resource('clients', ClientController::class);