@extends('layouts.app')
@section('content')

<div class="card">
  <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <span>Mis Clientes</span>
    <a href="{{ route('clients.create') }}" class="btn btn-primary mt-2 mt-sm-0">
      <i class="bx bx-plus me-1"></i>
      <span class="d-none d-sm-inline">Agregar Nuevo Cliente</span>
      <span class="d-inline d-sm-none">Nuevo</span>
    </a>
  </h5>

    <div class="table-responsive text-nowrap">
      
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre</th>
            <th class="hide-mobile">Teléfono</th>
            <th class="hide-mobile">Servicio</th>
            <th>Monto</th>
            <th class="hide-mobile">Suscripción</th>
            <th>Próximo Pago</th>
            <th class="hide-mobile">Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($clients as $client)
            <tr>
              <td>
                <strong>{{ $client->name }}</strong>
                <div class="d-block d-md-none small text-muted">
                  {{ $client->phone_number }}
                </div>
              </td>
              <td class="hide-mobile">{{ $client->phone_number }}</td>
              <td class="hide-mobile">{{ $client->service_type }}</td>
              <td>
                ${{ number_format($client->payment_amount, 2) }}
                @if ($client->payment_status == 'pagado')
                  <span class="badge bg-label-success me-1 d-block d-md-none mt-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1 d-block d-md-none mt-1">Pendiente</span>
                @endif
              </td>
              <td class="hide-mobile">{{ \Carbon\Carbon::parse($client->subscription_date)->format('d/m/Y') }}</td>
              <td>{{ $client->next_payment_date->format('d/m/Y') }}</td>
              
              <td class="hide-mobile">
                @if ($client->payment_status == 'pagado')
                  <span class="badge bg-label-success me-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1">Pendiente</span>
                @endif
              </td>
              <!-- Acciones -->
              <td>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-info">
                  <i class="bx bx-edit-alt d-inline d-md-none"></i>
                  <span class="d-none d-md-inline">Editar</span>
                </a>

                <button 
                  type="button" 
                  class="btn btn-sm btn-secondary" 
                  data-bs-toggle="modal" 
                  data-bs-target="#historyModal" 
                  data-client-id="{{ $client->id }}"
                  data-client-name="{{ $client->name }}">
                  <i class="bx bx-show d-inline d-md-none"></i>
                  <span class="d-none d-md-inline">Ver</span>
                </button>

                <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                    <i class="bx bx-trash d-inline d-md-none"></i>
                    <span class="d-none d-md-inline">Borrar</span>
                  </button>
                </form>
              </td>
            </tr>
          @empty

            <tr>
              <td colspan="8" class="text-center">No hay clientes registrados todavía.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
</div>

@endsection

<div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="history-modal-title">Historial de Pagos</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body" id="history-modal-body">
        <p class="text-center">Cargando historial...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

@push('page-scripts')
<script>
  // 1. Busca el modal en el HTML
  const historyModal = document.getElementById('historyModal');
  const modalTitle = document.getElementById('history-modal-title');
  const modalBody = document.getElementById('history-modal-body');

  // 2. Escucha el evento 'show.bs.modal' (se dispara JUSTO ANTES de abrirse)
  historyModal.addEventListener('show.bs.modal', function (event) {

    // 3. Obtiene el botón que fue clickeado
    const button = event.relatedTarget;

    // 4. Saca los datos que pusimos en los atributos data-
    const clientId = button.dataset.clientId;
    const clientName = button.dataset.clientName;

    // 5. Pone el título y el estado de "Cargando..."
    modalTitle.textContent = 'Historial de: ' + clientName;
    modalBody.innerHTML = '<p class="text-center">Cargando historial...</p>';

    // 6. Pide los datos al servidor (AJAX)
    fetch(`/clients/${clientId}/history`)
      .then(response => response.json())
      .then(data => {

        // 7. Construye la tabla del historial
        let html = '<table class="table table-striped">';
        html += '<thead><tr><th>Periodo Cubierto</th><th>Monto</th><th>Registrado el</th></tr></thead><tbody>';

        if (data.payments.length > 0) {
          data.payments.forEach(payment => {
            html += `
              <tr>
                <td>${payment.date}</td>
                <td>${payment.amount_formatted}</td>
                <td>${payment.registered}</td>
              </tr>
            `;
          });
        } else {
          html += '<tr><td colspan="3" class="text-center">No hay pagos registrados.</td></tr>';
        }

        html += '</tbody></table>';

        // 8. Inyecta la tabla en el cuerpo del modal
        modalBody.innerHTML = html;
      })
      .catch(error => {
        console.error('Error al cargar el historial:', error);
        modalBody.innerHTML = '<p class="text-danger text-center">No se pudo cargar el historial.</p>';
      });
  });
</script>
@endpush