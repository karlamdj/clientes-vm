<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController; 
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Protected Routes - Require Authentication
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    Route::get('/historial', [HistoryController::class, 'index'])->name('history.index');
    Route::post('clients/{client}/record-courtesy', [ClientController::class, 'recordCourtesy'])
          ->name('clients.recordCourtesy');

    Route::post('clients/{client}/confirm-payment', [ClientController::class, 'confirmPayment'])
          ->name('clients.confirmPayment');

    Route::resource('clients', ClientController::class);
    Route::get('/clients/{client}/history', [ClientController::class, 'getPaymentHistory'])
          ->name('clients.history');

    Route::resource('expenses', ExpenseController::class);

    Route::get('/pagos', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/pagos/{expense}/confirm', [PaymentController::class, 'confirmPayment'])
          ->name('payments.confirm');
    
    Route::resource('users', UserController::class);
});

// Authentication Routes
require __DIR__.'/auth.php';

