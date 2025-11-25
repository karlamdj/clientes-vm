@extends('layouts.app')

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Editar Cliente: {{ $client->name }}</h5>
        <div class="card-body">

            <form action="{{ route('clients.update', $client) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}"
                        required />
                </div>

                <div class="mb-3">
                    <label for="company" class="form-label">Empresa (Opcional):</label>
                    <input type="text" class="form-control" id="company" name="company"
                        value="{{ $client->company }}" />
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Teléfono (WhatsApp):</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                        value="{{ $client->phone_number }}" required />
                </div>

                <div class="mb-3">
                    <label for="service_type" class="form-label">Servicio:</label>
                    <select class="form-select" id="service_type" name="service_type" required>
                        <option value="">Selecciona un servicio</option>
                        <option value="vm_eats"
                            {{ ($client->service_type ?? old('service_type')) == 'vm_eats' ? 'selected' : '' }}>VM Eats
                        </option>
                        <option value="vm_tech"
                            {{ ($client->service_type ?? old('service_type')) == 'vm_tech' ? 'selected' : '' }}>VM
                            Technologies</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="payment_amount" class="form-label">Monto a Cobrar:</label>
                    <input type="number" step="0.01" class="form-control" id="payment_amount" name="payment_amount"
                        value="{{ $client->payment_amount }}" required />
                </div>

                <div class="mb-3">
                    <label for="subscription_date" class="form-label">Fecha de Suscripción:</label>
                    <input type="date" class="form-control" id="subscription_date" name="subscription_date"
                        value="{{ $client->subscription_date->format('Y-m-d') }}" required />
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <a href="{{ route('clients.index') }}" class="btn btn-secondary flex-fill flex-sm-grow-0">
                        <i class="bx bx-arrow-back me-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary flex-fill flex-sm-grow-0">
                        <i class="bx bx-save me-1"></i> Actualizar Cliente
                    </button>
                </div>

            </form>
        </div>
    </div>
@endsection
