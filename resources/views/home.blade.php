@extends('layouts.app')

@section('content')

<div class="card mb-4"> <h5 class="card-header">Resumen de Próximos Pagos</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Empresa</th>
          <th>Próximo Pago</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($clients as $client)
          <tr>
            <td><strong>{{ $client->name }}</strong></td>
            <td>{{ $client->company }}</td>
            <td>{{ $client->next_payment_date->format('d/m/Y') }}</td>
            <td>
              @if ($client->payment_status == 'pagado')
                <span class="badge bg-label-success me-1">Pagado</span>
              @else
                <span class="badge bg-label-warning me-1">Pendiente</span>
              @endif
            </td>
            <td>
              <form action="{{ route('clients.confirmPayment', $client) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Confirmar Pago</button>
              </form>

              <form action="{{ route('clients.recordCourtesy', $client) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-secondary" onclick="return confirm('¿Seguro que quieres registrar un mes de cortesía (sin pago)?')">Cortesía</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center">No hay clientes registrados todavía.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="card calendar-card-container">
  <div class="card-header">
    <h5 class="card-title">Calendario de Pagos</h5>
  </div>
  <div class="card-body">
    <div id="calendar"></div>
  </div>
</div>
@endsection


@push('page-scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    try {
      var calendarEl = document.getElementById('calendar');
      var events = @json($calendarEvents);
      
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,dayGridWeek,listMonth'
        },
        buttonText: {
          today: 'Hoy',
          month: 'Mes',
          week: 'Semana',
          list: 'Lista'
        },
        dayMaxEvents: true,
        events: events,
        eventClick: function(info) {
          var props = info.event.extendedProps;
          var status = props.status == 'pendiente' ? 
            'Pendiente ⚠️' : 
            'Pagado ✅';
          
          var message = 
            '📋 Cliente: ' + info.event.title + '\n' +
            '💰 Monto: ' + props.amount + '\n' +
            '📞 Teléfono: ' + props.phone + '\n' +
            '🔧 Servicio: ' + props.service + '\n' +
            '📊 Estado: ' + status + '\n' +
            '📅 Fecha: ' + info.event.start.toLocaleDateString('es-ES');
          
          alert(message);
        },
        eventContent: function(arg) {
          return {
            html: '<div class="fc-event-main-frame">' +
                  '<div class="fc-event-title-container">' +
                  '<div class="fc-event-title fc-sticky">' + arg.event.title + '</div>' +
                  '</div></div>'
          };
        }
      });
      
      calendar.render();
    } catch (e) {
      console.error("Error al renderizar FullCalendar:", e);
    }
  });
</script>
@endpush