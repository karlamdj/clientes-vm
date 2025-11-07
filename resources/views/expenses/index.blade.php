@extends('layouts.app')

@section('content')
<div class="card">
  <h5 class="card-header">Administrador de Gastos Fijos</h5>
  <div class="card-body">
    
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Gasto</a>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre del Gasto</th>
            <th>Monto</th>
            <th>Día de Vencimiento</th>
            <th>Estado</th>
            <th>Próximo Vencimiento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($expenses as $expense)
            <tr>
              <td><strong>{{ $expense->name }}</strong></td>
              <td>${{ number_format($expense->amount, 2) }}</td>
              <td>Día {{ $expense->payment_day }} de cada mes</td>
              <td>
                @if ($expense->status == 'pagado')
                  <span class="badge bg-label-success me-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1">Pendiente</span>
                @endif
              </td>
              <td>{{ $expense->next_due_date->format('d/m/Y') }}</td>
              <td>
                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-info">Editar</a>
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Borrar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center">No has registrado ningún gasto fijo todavía.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection