<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment; // <-- 1. Importamos el modelo de Pagos

class HistoryController extends Controller
{

    public function index()
    {

        $payments = Payment::with('client')->latest()->get();

        return view('history.index', [
            'payments' => $payments
        ]);
    }
}