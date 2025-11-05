<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
</head>
<body>
    <h1>Mis Clientes</h1>

    <a href="{{ route('clients.create') }}">Agregar Nuevo Cliente</a>

    @forelse ($clients as $client)
        <p>{{ $client->name }} - {{ $client->service_type }}</p>
    @empty
        <p>No hay clientes registrados todavía.</p>
    @endforelse
    </body>
</html>