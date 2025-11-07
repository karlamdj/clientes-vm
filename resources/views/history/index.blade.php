@extends('layouts.app')

@section('content')
<div class="card">
  <h5 class="card-header">Historial de Pagos</h5>
  <div class="table-responsive text-nowrap">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Cliente</th>
          <th>Monto Pagado</th>
          <th>Periodo Cubierto</th>
          <th>Registrado el</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @forelse ($payments as $payment)
          <tr>
            <td><strong>{{ $payment->client->name }}</strong></td>
           <td>
              @if ($payment->amount == 0)
                <span class="badge bg-label-info">Cortesía</span>
              @else
                ${{ number_format($payment->amount, 2) }}
              @endif
            </td>
            <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
            <td>{{ $payment->created_at->format('d/m/Y h:ia') }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="4" class="text-center">No hay pagos registrados en el historial.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection