@extends('layouts.auth')

@section('title', 'Registro')

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Logo -->
        <div class="app-brand justify-content-center mb-4">
            <a href="{{ route('login') }}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="VM Tech Logo" style="max-width: 180px; max-height: 50px; width: auto; height: auto;">
                </span>
            </a>
        </div>
        <!-- /Logo -->
        
        <h4 class="mb-2 text-center">Comienza tu aventura! 🚀</h4>
        <p class="mb-4 text-center">¡Haz que la gestión de pagos sea fácil y divertida!</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" 
                       placeholder="Ingresa tu nombre" autofocus required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="Ingresa tu email" required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                           required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                <div class="input-group input-group-merge">
                    <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                           name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                           required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button class="btn btn-primary d-grid w-100 mb-3" type="submit">Registrarse</button>
        </form>

        <p class="text-center">
            <span>¿Ya tienes una cuenta?</span>
            <a href="{{ route('login') }}">
                <span>Iniciar sesión</span>
            </a>
        </p>
    </div>
</div>
@endsection
