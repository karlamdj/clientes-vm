<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; // <-- Importamos el Modelo
use App\Models\Payment;
use App\Models\ExpensePayment;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal (Home).
     */
    public function index()
{
    $clients = Client::all();
    $today = Carbon::today();

    // Eventos de próximos pagos (basados en next_payment_date de clientes)
    $calendarEvents = $clients->map(function ($client) {
        $color = $client->payment_status == 'pendiente' ? '#ff9f43' : '#28c76f'; // Warning / Success
        return [
            'title' => $client->name . ' - ' . $client->company,
            'start' => $client->next_payment_date->format('Y-m-d'), // Formato YYYY-MM-DD
            'backgroundColor' => $color,
            'borderColor' => $color,
            'extendedProps' => [
                'amount' => '$' . number_format($client->payment_amount, 2),
                'phone' => $client->phone_number,
                'service' => $client->service_type,
                'status' => $client->payment_status
            ]
        ];
    });

    // Agregar pagos confirmados del mes actual al calendario (en verde)
    $payments = Payment::with('client')
        ->whereYear('payment_date', $today->year)
        ->whereMonth('payment_date', $today->month)
        ->get();

    $paymentsEvents = $payments->map(function ($payment) {
        return [
            'title' => $payment->client->name . ' - ' . $payment->client->company . ' ✅',
            'start' => $payment->payment_date->format('Y-m-d'),
            'backgroundColor' => '#28c76f', // Verde para pagos confirmados
            'borderColor' => '#28c76f',
            'extendedProps' => [
                'amount' => '$' . number_format($payment->amount, 2),
                'phone' => $payment->client->phone_number,
                'service' => $payment->client->service_type,
                'status' => 'pagado'
            ]
        ];
    });

    // Combinar eventos: próximos pagos + pagos confirmados
    $calendarEvents = $calendarEvents->merge($paymentsEvents);

    $totalIngresos = Payment::whereYear('payment_date', $today->year)
                        ->whereMonth('payment_date', $today->month)
                        ->sum('amount');

        $totalGastos = ExpensePayment::whereYear('payment_date', $today->year)
                                     ->whereMonth('payment_date', $today->month)
                                     ->sum('amount');

        $totalGanancias = $totalIngresos - $totalGastos;

        return view('home', [
            'clients'        => $clients,
            'calendarEvents' => $calendarEvents,
            'totalIngresos'  => $totalIngresos,
            'totalGastos'    => $totalGastos,
            'totalGanancias' => $totalGanancias,
        ]);
}
}
