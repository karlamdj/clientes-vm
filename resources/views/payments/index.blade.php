@extends('layouts.app')

@section('content')
<div class="card">
  <h5 class="card-header">Pagos Pendientes</h5>
  <div class="card-body">
    <div class="table-responsive text-nowrap">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre del Gasto</th>
            <th>Monto a Pagar</th>
            <th>Fecha de Vencimiento</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($pendingExpenses as $expense)
            <tr>
              <td><strong>{{ $expense->name }}</strong></td>
              <td>${{ number_format($expense->amount, 2) }}</td>
              <td>
                <span class="text-danger">{{ $expense->next_due_date->format('d/m/Y') }}</span>
              </td>
              <td>
                <form action="{{ route('payments.confirm', $expense) }}" method="POST" style="display:inline;">
  @csrf
  <button type="submit" class="btn btn-sm btn-success">Marcar como Pagado</button>
</form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center">¡Excelente! No tienes ningún pago vencido o pendiente para hoy.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection