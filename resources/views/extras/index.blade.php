@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Registrar Extra</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('extras.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Concepto / Trabajo</label>
                        <input type="text" class="form-control" name="concept" placeholder="Ej: Formateo PC" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Monto Cobrado</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" name="amount" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Ingreso</label>
                        <input type="date" class="form-control" name="income_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas (Opcional)</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrar Ingreso</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <h5 class="card-header">Historial de Ingresos Extras</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Concepto</th>
                            <th>Monto</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($extras as $extra)
                        <tr>
                            <td>{{ $extra->income_date->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $extra->concept }}</strong>
                                @if($extra->notes)
                                    <br><small class="text-muted">{{Str::limit($extra->notes, 30)}}</small>
                                @endif
                            </td>
                            <td><span class="text-success fw-bold">+ ${{ number_format($extra->amount, 2) }}</span></td>
                            <td>
                                <form action="{{ route('extras.destroy', $extra) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('¿Borrar este registro?')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">No hay ingresos extras registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection