@extends('layouts.app')

@section('content')
<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Configuración /</span> Plantillas de Mensajes
</h4>

<div class="card mb-4">
  <div class="card-body">
    <form method="GET" action="{{ route('settings.templates.index') }}" class="d-flex align-items-center">
      <label for="service-select" class="form-label me-3 mb-0"><strong>Seleccionar Servicio:</strong></label>
      <select class="form-select" id="service-select" name="service" onchange="this.form.submit();" style="width: 250px;">
        @foreach ($services as $serviceKey => $serviceName)
          <option value="{{ $serviceKey }}" {{ $selectedService == $serviceKey ? 'selected' : '' }}>
            {{ $serviceName }}
          </option>
        @endforeach
      </select>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h5 class="card-title">Editando Plantillas para: <strong>{{ $services[$selectedService] ?? 'VM Technologies' }}</strong></h5>
    <p class="text-muted">Variables disponibles: <code>{{'{'}}CLIENT_NAME{{'}'}}</code>, <code>{{'{'}}PRODUCT_NAME{{'}'}}</code>, <code>{{'{'}}AMOUNT{{'}'}}</code>>, <code>{{'{'}}DUE_DATE{{'}'}}</code></p>
  </div>
  <div class="card-body">
    <form action="{{ route('settings.templates.update') }}" method="POST">
      @csrf
      @method('PUT')

      <input type="hidden" name="service" value="{{ $selectedService }}">

      <div class="mb-3">
        <label for="template_5_days_before" class="form-label"><strong>5 Días Antes del Vencimiento</strong></label>
        <textarea class="form-control" id="template_5_days_before" name="templates[5_days_before]" rows="4">{{ $templates['5_days_before'] }}</textarea>
      </div>

      <div class="mb-3">
        <label for="template_due_date" class="form-label"><strong>Día del Vencimiento</strong></label>
        <textarea class="form-control" id="template_due_date" name="templates[due_date]" rows="4">{{ $templates['due_date'] }}</textarea>
      </div>

      <div class="mb-3">
        <label for="template_5_days_after" class="form-label"><strong>5 Días Después del Vencimiento</strong></label>
        <textarea class="form-control" id="template_5_days_after" name="templates[5_days_after]" rows="4">{{ $templates['5_days_after'] }}</textarea>
      </div>

      <div class="mb-3">
        <label for="template_10_days_after" class="form-label"><strong>10 Días Después (Cancelación)</strong></label>
        <textarea class="form-control" id="template_10_days_after" name="templates[10_days_after]" rows="4">{{ $templates['10_days_after'] }}</textarea>
      </div>

      <button type="submit" class="btn btn-primary">Guardar Cambios</button>

      @if (session('success'))
        <span class="ms-3 text-success">{{ session('success') }}</span>
      @endif
    </form>
  </div>
</div>
@endsection