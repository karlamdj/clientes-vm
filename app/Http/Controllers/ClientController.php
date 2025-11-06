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
        // 1. Obtenemos la fecha del próximo pago actual
        $currentPaymentDate = Carbon::parse($client->next_payment_date);

        // 2. Calculamos la NUEVA fecha de próximo pago (sumándole un mes)
        //    (Usamos 'addMonthNoOverflow' por si pagan el 31 y el prox mes tiene 30)
        $newNextPaymentDate = $currentPaymentDate->addMonthNoOverflow(); // <-- AQUÍ SE CREA LA VARIABLE

        // 3. Actualizamos al cliente:
        //    - Ponemos el estado en 'pagado'
        //    - Establecemos la fecha del *próximo* ciclo
        $client->update([
            'payment_status' => 'pagado',
            'next_payment_date' => $newNextPaymentDate // <-- AQUÍ SE USA
        ]);

        // 4. Redirigimos CON el mensaje de éxito
        return redirect()->route('clients.index')
            ->with('success', '¡Pago confirmado exitosamente!');
    }

}
