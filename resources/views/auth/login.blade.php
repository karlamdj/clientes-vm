@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-container">
    <div class="login-card">
        <!-- Lemur Image -->
        <div class="lemur-container">
            <img src="{{ asset('assets/img/login/lemur.png') }}" alt="Lemur Mascot" class="lemur-image">
        </div>

        <!-- Login Form -->
        <div class="login-form-container">
            <h1 class="login-title">VM Technologies</h1>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <!-- Email/Username -->
                <div class="input-group-custom">
                    <i class="bx bx-user input-icon"></i>
                    <input type="email" 
                           class="form-control-custom @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Username" 
                           autofocus 
                           required />
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group-custom">
                    <i class="bx bx-lock-alt input-icon"></i>
                    <input type="password" 
                           id="password" 
                           class="form-control-custom @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="Password" 
                           required />
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="login-options">
                    <label class="remember-me">
                        <input type="checkbox" id="remember_me" name="remember">
                        <span>Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button class="btn-login" type="submit">LOGIN</button>
            </form>
        </div>
    </div>
</div>
@endsection
