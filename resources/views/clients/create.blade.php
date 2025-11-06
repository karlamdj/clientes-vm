<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Cliente</title>
</head>
<body>
    <h1>Crear Nuevo Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST">
        
        @csrf

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="company">Empresa (Opcional):</label>
            <input type="text" id="company" name="company">
        </div>

        <div>
            <label for="phone_number">Teléfono (WhatsApp):</label>
            <input type="text" id="phone_number" name="phone_number" required>
        </div>

        <div>
            <label for="service_type">Tipo de Servicio:</label>
            <input type="text" id="service_type" name="service_type" required>
        </div>

        <div>
            <label for="payment_amount">Monto a Cobrar:</label>
            <input type="number" step="0.01" id="payment_amount" name="payment_amount" required>
        </div>

        <div>
            <label for="subscription_date">Fecha de Suscripción:</label>
            <input type="date" id="subscription_date" name="subscription_date" required>
        </div>
        <button type="submit">Guardar Cliente</button>
    </form>

</body>
</html>