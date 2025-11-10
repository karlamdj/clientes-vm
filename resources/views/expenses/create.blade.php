@extends('layouts.app')

@section('content')
<div class="card mb-4">
  <h5 class="card-header">Registrar Nuevo Gasto Fijo</h5>
  <div class="card-body">
    <form action="{{ route('expenses.store') }}" method="POST">
      @csrf

      <div class="mb-3">
        <label for="name" class="form-label">Nombre del Gasto:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Ej: Renta de Oficina" required />
      </div>

      <div class="mb-3">
        <label for="amount" class="form-label">Monto a Pagar:</label>
        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required />
      </div>

      <div class="mb-3">
        <label for="payment_day" class="form-label">Día de Vencimiento (del mes):</label>
        <input type="number" class="form-control" id="payment_day" name="payment_day" min="1" max="31" placeholder="Ej: 15" required />
      </div>

      <div class="d-flex justify-content-between flex-wrap gap-2">
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary flex-fill flex-sm-grow-0">
          <i class="bx bx-arrow-back me-1"></i> Cancelar
        </a>
        <button type="submit" class="btn btn-primary flex-fill flex-sm-grow-0">
          <i class="bx bx-save me-1"></i> Guardar Gasto
        </button>
      </div>

    </form>
  </div>
</div>
@endsection