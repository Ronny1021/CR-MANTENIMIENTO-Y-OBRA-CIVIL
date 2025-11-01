@extends('layouts.app')

@section('content')
<div class="register-wrapper">
    <div class="register-card">
        <h2 class="register-title">{{ __('Registro') }}</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password" required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                <input id="password-confirm" type="password" class="form-control"
                       name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary">Registrar</button>
                <a class="btn btn-link" href="{{ route('login') }}">¿Ya tienes cuenta?</a>
            </div>
        </form>
             <div class="login-image">
  <img src="{{ asset('images/imagefooter (2).png') }}" alt="Imagen decorativa">
    </div>
</div>
@endsection
