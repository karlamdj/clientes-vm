<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client; // <-- Importamos el Modelo

class DashboardController extends Controller
{
    /**
     * Muestra el dashboard principal (Home).
     */
    public function index()
{
    $clients = Client::all();

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

    return view('home', [
        'clients'        => $clients,
        'calendarEvents' => $calendarEvents // <-- Nueva variable
    ]);
}
}
