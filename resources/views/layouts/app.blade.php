<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Configuración básica del documento -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Seguridad para formularios -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Título dinámico desde config/app.php -->
    <title>{{ config('app.name', 'CR') }}</title>

    <!-- Fuente externa -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Estilos y scripts compilados con Vite -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <!-- Barra de navegación principal -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Logo o nombre del sistema -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'CR') }}
                </a>

                <!-- Botón para menú responsive -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Contenido del menú -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Menú izquierdo: enlaces principales -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('empleado.index') }}">Empleados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/inventario') }}">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('nomina.index') }}">Asistencia</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('certificados.form') }}">Certificados</a>
                        </li>
                    </ul>

                    <!-- Menú derecho: autenticación -->
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @else
                            <!-- Usuario autenticado -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <!-- Cierre de sesión -->
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
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

        <!-- Área principal donde se carga el contenido de cada vista -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
