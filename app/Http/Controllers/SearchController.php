<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Payment;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return redirect()->back();
        }

        // Buscar en clientes
        $clients = Client::where('name', 'LIKE', "%{$query}%")
            ->orWhere('company', 'LIKE', "%{$query}%")
            ->orWhere('phone_number', 'LIKE', "%{$query}%")
            ->orWhere('service_type', 'LIKE', "%{$query}%")
            ->get();

        // Buscar en gastos
        $expenses = Expense::where('name', 'LIKE', "%{$query}%")
            ->get();

        // Buscar en pagos
        $payments = Payment::with('client')
            ->whereHas('client', function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('company', 'LIKE', "%{$query}%");
            })
            ->get();

        return view('search.results', compact('query', 'clients', 'expenses', 'payments'));
    }
}
