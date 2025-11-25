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
                        <th class="d-none d-md-table-cell">Teléfono</th>
                        <th class="d-none d-md-table-cell">Servicio</th>
                        <th>Monto</th>
                        <th class="d-none d-md-table-cell">Suscripción</th>
                        <th>Próximo Pago</th>
                        <th class="d-none d-md-table-cell">Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($clients as $client)
                        <tr>
                            <td>
                                <strong>{{ $client->name }}</strong>
                                <div class="d-block d-md-none small text-muted">
                                    {{ $client->phone_number }} <br>
                                    {{ $client->service_display_name }}
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">{{ $client->phone_number }}</td>
                            <td class="d-none d-md-table-cell">{{ $client->service_display_name }}</td>

                            <td>
                                ${{ number_format($client->payment_amount, 2) }}
                                @if ($client->payment_status == 'pagado')
                                    <span class="badge bg-label-success me-1 d-block d-md-none mt-1">Pagado</span>
                                @else
                                    <span class="badge bg-label-warning me-1 d-block d-md-none mt-1">Pendiente</span>
                                @endif
                            </td>
                            
                            <td class="d-none d-md-table-cell">
                                {{ \Carbon\Carbon::parse($client->subscription_date)->format('d/m/Y') }}
                            </td>
                            <td>{{ $client->next_payment_date->format('d/m/Y') }}</td>

                            <td class="d-none d-md-table-cell">
                                @if ($client->payment_status == 'pagado')
                                    <span class="badge bg-label-success me-1">Pagado</span>
                                @else
                                    <span class="badge bg-label-warning me-1">Pendiente</span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-info" title="Editar">
                                    <i class="bx bx-edit-alt"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#historyModal" data-client-id="{{ $client->id }}"
                                    data-client-name="{{ $client->name }}" title="Ver Historial">
                                    <i class="bx bx-show"></i>
                                </button>

                                <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Estás seguro de eliminar este cliente?')" title="Borrar">
                                        <i class="bx bx-trash"></i>
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

    <div class="modal fade" id="historyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="history-modal-title">Historial de Pagos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
@endsection

@push('page-scripts')
    <script>
        const historyModal = document.getElementById('historyModal');
        const modalTitle = document.getElementById('history-modal-title');
        const modalBody = document.getElementById('history-modal-body');

        historyModal.addEventListener('show.bs.modal', function(event) {
            // Resetear el modal al abrir
            modalBody.innerHTML = '<div class="text-center py-3"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Cargando historial...</p></div>';
            
            const button = event.relatedTarget;
            const clientId = button.dataset.clientId;
            const clientName = button.dataset.clientName;

            modalTitle.textContent = 'Historial de: ' + clientName;

            fetch(`/clients/${clientId}/history`)
                .then(response => response.json())
                .then(data => {
                    let html = '<div class="table-responsive"><table class="table table-striped">';
                    html += '<thead><tr><th>Fecha Pago</th><th>Monto</th><th>Registrado el</th></tr></thead><tbody>';

                    if (data.payments && data.payments.length > 0) {
                        data.payments.forEach(payment => {
                            html += `
                                <tr>
                                    <td>${payment.date}</td>
                                    <td>${payment.amount_formatted}</td>
                                    <td>${payment.registered}</td>
                                </tr>`;
                        });
                    } else {
                        html += '<tr><td colspan="3" class="text-center py-3">No hay pagos registrados para este cliente.</td></tr>';
                    }

                    html += '</tbody></table></div>';
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalBody.innerHTML = '<div class="alert alert-danger text-center">Error al cargar el historial. Intente de nuevo.</div>';
                });
        });
    </script>
@endpush