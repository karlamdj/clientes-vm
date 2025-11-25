<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MessageTemplate;

class MessageTemplateController extends Controller
{
    // Define los disparadores y los servicios
    private $triggers = ['5_days_before', 'due_date', '5_days_after', '10_days_after'];
    private $services = ['vm_tech' => 'VM Technologies', 'vm_eats' => 'VM Eats'];

    /**
     * Muestra la página de edición de plantillas.
     */
    public function index(Request $request)
    {
        //  Obtiene el servicio del dropdown (o usa 'vm_tech' por defecto)
        $selectedService = $request->input('service', 'vm_tech');

        //  Busca las plantillas de ESE servicio en la BD
        $templatesData = MessageTemplate::where('service_name', $selectedService)->get();

        //  Prepara las plantillas para la vista
        $templates = [];
        foreach ($this->triggers as $trigger) {
            // Busca la plantilla para este disparador
            $template = $templatesData->firstWhere('trigger_event', $trigger);
            // Si no existe, usa un string vacío
            $templates[$trigger] = $template ? $template->message_body : '';
        }

        //  Manda los datos a la vista
        return view('settings.message-templates', [
            'services' => $this->services,
            'selectedService' => $selectedService,
            'templates' => $templates,
        ]);
    }

    /**
     * Guarda (actualiza) las plantillas de un servicio.
     */
    public function update(Request $request)
    {
        $request->validate([
            'service' => 'required|string',
            'templates' => 'required|array',
        ]);

        $service = $request->input('service');

        //  Recorre cada plantilla enviada desde el formulario
        foreach ($request->input('templates') as $trigger => $body) {

            //    - Busca una fila con este 'service_name' y 'trigger_event'
            //    - Si la encuentra, la actualiza con el 'message_body'
            //    - Si NO la encuentra, crea una nueva fila
            MessageTemplate::updateOrCreate(
                [
                    'service_name' => $service,
                    'trigger_event' => $trigger,
                ],
                [
                    'message_body' => $body ?? '', 
                ]
            );
        }

        return redirect()->back()
                         ->with('success', '¡Plantillas guardadas exitosamente!');
    }
}