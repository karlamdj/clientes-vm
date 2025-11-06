<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <h1>Editar Cliente: {{ $client->name }}</h1>

    <form action="{{ route('clients.update', $client) }}" method="POST">
        @csrf
        
        @method('PUT')

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $client->name }}" required>
        </div>

        <div>
            <label for="company">Empresa (Opcional):</label>
            <input type="text" id="company" name="company" value="{{ $client->company }}">
        </div>

        <div>
            <label for="phone_number">Teléfono (WhatsApp):</label>
            <input type="text" id="phone_number" name="phone_number" value="{{ $client->phone_number }}" required>
        </div>

        <div>
            <label for="service_type">Tipo de Servicio:</label>
            <input type="text" id="service_type" name="service_type" value="{{ $client->service_type }}" required>
        </div>

        <div>
            <label for="payment_amount">Monto a Cobrar:</label>
            <input type="number" step="0.01" id="payment_amount" name="payment_amount" value="{{ $client->payment_amount }}" required>
        </div>

        <div>
            <label for="subscription_date">Fecha de Suscripción:</label>
            <input type="date" id="subscription_date" name="subscription_date" value="{{ $client->subscription_date->format('Y-m-d') }}" required>
        </div>

        <button type="submit">Actualizar Cliente</button>
    </form>

</body>
</html>