<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ExpenseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/historial', [HistoryController::class, 'index'])->name('history.index');

Route::post('clients/{client}/record-courtesy', [ClientController::class, 'recordCourtesy'])
      ->name('clients.recordCourtesy');

Route::post('clients/{client}/confirm-payment', [ClientController::class, 'confirmPayment'])
      ->name('clients.confirmPayment');

Route::resource('clients', ClientController::class);

Route::resource('expenses', ExpenseController::class);