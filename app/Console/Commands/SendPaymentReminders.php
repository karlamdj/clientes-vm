<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Client;    
use Carbon\Carbon;          
use Illuminate\Support\Facades\Log; 

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // CAMBIAMOS EL APODO del comando
    protected $signature = 'app:send-payment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca clientes con pagos vencidos hoy y (eventualmente) envía recordatorios.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // ESTA ES LA LÓGICA PRINCIPAL
        
        $this->info('Buscando clientes con vencimiento hoy...');

        // Obtenemos la fecha de "hoy"
        $today = Carbon::today()->toDateString();

        // Buscamos en la BD clientes cuya "next_payment_date" sea igual a hoy
        $clientsToRemind = Client::where('next_payment_date', $today)->get();

        if ($clientsToRemind->isEmpty()) {
            $this->info('No hay clientes para notificar hoy.');
            // También lo escribimos en el archivo de log de Laravel
            Log::info('No hay clientes para notificar hoy.');
            return;
        }

        // Si encontramos clientes, los recorremos
        foreach ($clientsToRemind as $client) {
            $this->info("Recordatorio pendiente para: {$client->name}");
            
            // --- PRUEBA DE FUNCIONAMIENTO ---
       
            Log::info("Recordatorio de pago enviado (simulación) a: {$client->name} al {$client->phone_number}");
        }

        $this->info('Proceso de recordatorios terminado.');
    }
}
