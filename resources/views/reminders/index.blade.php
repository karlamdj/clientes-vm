@extends('layouts.app')

@section('title', 'Gestión de Recordatorios')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h4 class="fw-bold py-3 mb-0">
                <span class="text-muted fw-light">Admin /</span> Recordatorios
            </h4>
            <a href="{{ route('reminders.create') }}" class="btn btn-primary mt-2 mt-sm-0">
                <i class="bx bx-plus me-1"></i>
                <span class="d-none d-sm-inline">Nuevo Recordatorio</span>
                <span class="d-inline d-sm-none">Nuevo</span>
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Lista de Usuarios</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hide-mobile">Email</th>
                            <th class="hide-mobile">Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($reminders as $reminder)
                            <tr>
                                <td>
                                    <i class="bx bx-user me-2"></i>
                                    <strong>{{ $reminder->name }}</strong>
                                </td>
                                <td class="hide-mobile">{{ $reminder->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info">
                                        <i class="bx bx-edit-alt d-inline d-md-none"></i>
                                        <span class="d-none d-md-inline">Editar</span>
                                    </a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            <i class="bx bx-trash d-inline d-md-none"></i>
                                            <span class="d-none d-md-inline">Borrar</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay Recordatorios registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
