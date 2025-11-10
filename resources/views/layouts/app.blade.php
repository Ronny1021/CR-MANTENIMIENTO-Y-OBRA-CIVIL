<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.', 'CR Mantenimiento & Obra Civil') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo_icon.ico') }}">

    <!-- CDN de Font Awesome se queda aquí, ya que la vista 'acerca' lo necesita -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

@php
    $authViews = ['login', 'register'];
    $currentRoute = Route::currentRouteName();
    $bodyClass = in_array($currentRoute, $authViews) ? 'auth-body' : 'default-body';
@endphp

<body class="{{ $bodyClass }}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light {{ $bodyClass === 'auth-body' ? 'transparent-header' : 'bg-white shadow-sm' }}">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.', 'CR') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Menú izquierdo -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            @if (!in_array($currentRoute, $authViews))
                                <li class="nav-item"><a class="nav-link" href="{{ route('empleado.index') }}">Empleado</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ url('/inventario') }}">Inventario</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('nomina.index') }}">Asistencia</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('certificados.form') }}">Certificados</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('desprendible.form') }}">Desprendible</a></li>
                            @endif
                        @endauth
                        <!-- Enlace visible para todos -->

                        @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('acerca') }}">ACERCA DE</a></li>
                        @endguest

                    </ul>

                    <!-- Menú derecho -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registrar</a></li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
</html>