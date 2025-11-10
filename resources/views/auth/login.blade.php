@extends('layouts.auth')

@section('title', 'Login')

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
        
        <h4 class="mb-2 text-center">Bienvenido a VM Tech! 👋</h4>
        <p class="mb-4 text-center">Inicia sesión para continuar</p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" 
                       placeholder="Ingresa tu email" autofocus required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Contraseña</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            <small>¿Olvidaste tu contraseña?</small>
                        </a>
                    @endif
                </div>
                <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" 
                           aria-describedby="password" required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Remember Me -->
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        Recordarme
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Iniciar Sesión</button>
            </div>
        </form>
    </div>
</div>
@endsection
