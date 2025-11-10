@extends('layouts.app')

@section('content')
<div class="card">
  <h5 class="card-header d-flex justify-content-between align-items-center flex-wrap">
    <span>Administrador de Gastos Fijos</span>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary mt-2 mt-sm-0">
      <i class="bx bx-plus me-1"></i>
      <span class="d-none d-sm-inline">Registrar Nuevo Gasto</span>
      <span class="d-inline d-sm-none">Nuevo</span>
    </a>
  </h5>

    <div class="table-responsive text-nowrap">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Nombre del Gasto</th>
            <th>Monto</th>
            <th class="hide-mobile">Día de Vencimiento</th>
            <th class="hide-mobile">Estado</th>
            <th>Próximo Vencimiento</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($expenses as $expense)
            <tr>
              <td>
                <strong>{{ $expense->name }}</strong>
                <div class="d-block d-md-none small text-muted">
                  Día {{ $expense->payment_day }}
                </div>
              </td>
              <td>
                ${{ number_format($expense->amount, 2) }}
                @if ($expense->status == 'pagado')
                  <span class="badge bg-label-success me-1 d-block d-md-none mt-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1 d-block d-md-none mt-1">Pendiente</span>
                @endif
              </td>
              <td class="hide-mobile">Día {{ $expense->payment_day }} de cada mes</td>
              <td class="hide-mobile">
                @if ($expense->status == 'pagado')
                  <span class="badge bg-label-success me-1">Pagado</span>
                @else
                  <span class="badge bg-label-warning me-1">Pendiente</span>
                @endif
              </td>
              <td>{{ $expense->next_due_date->format('d/m/Y') }}</td>
              <td>
                <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-sm btn-info">
                  <i class="bx bx-edit-alt d-inline d-md-none"></i>
                  <span class="d-none d-md-inline">Editar</span>
                </a>
                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este gasto?')">
                    <i class="bx bx-trash d-inline d-md-none"></i>
                    <span class="d-none d-md-inline">Borrar</span>
                  </button>
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
@endsection