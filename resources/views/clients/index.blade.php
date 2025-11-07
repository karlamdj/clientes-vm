@extends('layouts.app')
@section('content')

<div class="card">
  <h5 class="card-header">Mis Clientes</h5>
  <div class="card-body">
    
    <a href="{{ route('clients.create') }}" class="btn btn-primary mb-3">Agregar Nuevo Cliente</a>

    <div class="table-responsive text-nowrap">
      
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Servicio</th>
            <th>Monto</th>
            <th>Próximo Pago</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($clients as $client)
            <tr>
              <td><strong>{{ $client->name }}</strong></td>
              <td>{{ $client->phone_number }}</td>
              <td>{{ $client->service_type }}</td>
              <td>${{ number_format($client->payment_amount, 2) }}</td>
              <td>{{ $client->next_payment_date->format('d/m/Y') }}</td>
              
              <td>
                @if ($client->payment_status == 'pagado')
                  <span class="badge bg-label-success me-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1">Pendiente</span>
                @endif
              </td>
              <!-- Acciones -->
              <td>
              <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-info">Editar</a>

              <form action="{{ route('clients.destroy', $client) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Borrar</button>
              </form>

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
              <td colspan="7" class="text-center">No hay clientes registrados todavía.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection