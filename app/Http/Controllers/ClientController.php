<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Carbon\Carbon;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'company',
            'phone_number',
            'service_type',
            'payment_amount',
            'subscription_date'
        ]);

        $suscriptionDate = Carbon::parse($data['subscription_date']);

        $data['next_payment_date'] = $suscriptionDate->addMonth()->toDateString();

        Client::create($data);
        return redirect()->route('clients.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('clients.edit', [
            'client' => Client::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->only([
            'name',
            'company',
            'phone_number',
            'service_type',
            'payment_amount',
            'subscription_date'
        ]);
        $suscriptionDate = Carbon::parse($data['subscription_date']);
        $data['next_payment_date'] = $suscriptionDate->addMonth()->toDateString();

        $client->update($data);
        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index');
    }
    /**
     * Confirma el pago de un cliente y recalcula el próximo vencimiento.
     */
    public function confirmPayment(Client $client)
    {
        $paymentDateToRecord = Carbon::parse($client->next_payment_date);
        $amountToRecord = $client->payment_amount;

        $client->payments()->create([
            'amount' => $amountToRecord,
            'payment_date' => $paymentDateToRecord
        ]);

        $newNextPaymentDate = $paymentDateToRecord->addMonthNoOverflow();

        $client->update([
            'payment_status' => 'pagado',
            'next_payment_date' => $newNextPaymentDate
        ]);

        return redirect()->back() // Usamos redirect()->back() para que funcione desde Home o Clientes
            ->with('success', '¡Pago confirmado!');
    }

    public function getPaymentHistory(Client $client)
{
    // 1. Cargamos los pagos, ordenados del más nuevo al más viejo
    $payments = $client->payments()->orderBy('payment_date', 'desc')->get();

    // 2. Formateamos los datos para que JS los use fácilmente
    $formattedPayments = $payments->map(function($payment) {
        return [
            'date' => $payment->payment_date->format('d/m/Y'),
            'amount_formatted' => $payment->amount == 0 
                                  ? '<span class="badge bg-label-info">Cortesía</span>' 
                                  : '$' . number_format($payment->amount, 2),
            'registered' => $payment->created_at->format('d/m/Y h:ia')
        ];
    });

    // 3. Devolvemos los datos del cliente Y sus pagos
    return response()->json([
        'payments' => $formattedPayments
    ]);
}

    public function recordCourtesy(Client $client)
    {
        $paymentDateToRecord = Carbon::parse($client->next_payment_date);

         $client->payments()->create([
            'amount' => 0, // 
            'payment_date' => $paymentDateToRecord
        ]);

            $newNextPaymentDate = $paymentDateToRecord->addMonthNoOverflow();

         $client->update([
            'payment_status' => 'pagado', // Lo marcamos como 'pagado' 
            'next_payment_date' => $newNextPaymentDate
        ]);

        return redirect()->back()
            ->with('success', '¡Mes de cortesía registrado!');
    }
}
