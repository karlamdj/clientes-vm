@extends('layouts.app')
@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Resultados de búsqueda para:</span> "{{ $query }}"
  </h4>

  <!-- Clientes -->
  @if($clients->count() > 0)
  <div class="card mb-4">
    <h5 class="card-header">
      <i class='bx bx-group'></i> Clientes ({{ $clients->count() }})
    </h5>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Empresa</th>
              <th>Teléfono</th>
              <th>Servicio</th>
              <th>Monto</th>
              <th>Próximo Pago</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
            <tr>
              <td><strong>{{ $client->name }}</strong></td>
              <td>{{ $client->company }}</td>
              <td>{{ $client->phone_number }}</td>
              <td>{{ $client->service_type }}</td>
              <td>${{ number_format($client->payment_amount, 2) }}</td>
              <td>{{ $client->next_payment_date->format('d/m/Y') }}</td>
              <td>
                <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-info">
                  <i class='bx bx-edit'></i> Ver
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  <!-- Gastos -->
  @if($expenses->count() > 0)
  <div class="card mb-4">
    <h5 class="card-header">
      <i class='bx bx-wallet'></i> Gastos ({{ $expenses->count() }})
    </h5>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Monto</th>
              <th>Día de Pago</th>
              <th>Próximo Vencimiento</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenses as $expense)
            <tr>
              <td><strong>{{ $expense->name }}</strong></td>
              <td>${{ number_format($expense->amount, 2) }}</td>
              <td>{{ $expense->payment_day }}</td>
              <td>{{ \Carbon\Carbon::parse($expense->next_due_date)->format('d/m/Y') }}</td>
              <td>
                @if($expense->status == 'pagado')
                  <span class="badge bg-success">Pagado</span>
                @else
                  <span class="badge bg-warning">Pendiente</span>
                @endif
              </td>
              <td>
                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-info">
                  <i class='bx bx-edit'></i> Ver
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  <!-- Pagos Realizados -->
  @if($payments->count() > 0)
  <div class="card mb-4">
    <h5 class="card-header">
      <i class='bx bx-dollar'></i> Pagos Registrados ({{ $payments->count() }})
    </h5>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Empresa</th>
              <th>Monto</th>
              <th>Fecha de Pago</th>
            </tr>
          </thead>
          <tbody>
            @foreach($payments as $payment)
            <tr>
              <td><strong>{{ $payment->client->name }}</strong></td>
              <td>{{ $payment->client->company }}</td>
              <td>${{ number_format($payment->amount, 2) }}</td>
              <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endif

  <!-- Sin Resultados -->
  @if($clients->count() == 0 && $expenses->count() == 0 && $payments->count() == 0)
  <div class="card">
    <div class="card-body text-center py-5">
      <i class='bx bx-search-alt bx-lg text-muted mb-3'></i>
      <h5 class="text-muted">No se encontraron resultados</h5>
      <p class="text-muted">Intenta con otra búsqueda</p>
      <a href="{{ route('home') }}" class="btn btn-primary">
        <i class='bx bx-home'></i> Volver al Inicio
      </a>
    </div>
  </div>
  @endif

</div>

@endsection
