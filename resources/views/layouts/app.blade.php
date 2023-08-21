<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IMCAD') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand">
                    {{ config('app.name', 'IMCAD') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav nav-tabs navbar-nav me-auto">

                        @role('cotrrsa hombres')
                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('cotrrsaHombresView') }}">Inventario</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('petitionHombres.petitionView') }}">Lista de Requisicion</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('pdfSaveForm.view') }}">Enviar Lista Creada</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Estados de Lista
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.table') }}">Listas Pendientes</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.approveFileView') }}">Listas Aprobadas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.denyFileView') }}">Listas Denegadas</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Registro de Acciones
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs')}}">ALTAS de Productos</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs-discount')}}">BAJAS de Productos</a>
                                </li>
                            </ul>
                        </li>

                        @endrole

                        @role('cotrrsa mujeres')
                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('cotrrsaMujeresView') }}">Inventario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('petitionMujeres.petitionView') }}">Lista de Requisicion</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('pdfSaveForm.view') }}">Enviar Lista Creada</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Estados de Lista
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.table') }}">Listas Pendientes</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.approveFileView') }}">Listas Aprobadas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.denyFileView') }}">Listas Denegadas</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Registro de Acciones
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs')}}">ALTAS de Productos</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs-discount')}}">BAJAS de Productos</a>
                                </li>
                            </ul>
                        </li>
                        @endrole

                        @role('administracion')
                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('cotrrsaHombresView') }}">Inventario COTRRSA Hombres</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link link-dark" href="{{ route('cotrrsaMujeresView') }}">Inventario COTRRSA Mujeres</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Estados de Lista
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.table') }}">Listas Pendientes</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.approveFileView') }}">Listas Aprobadas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('pdf.denyFileView') }}">Listas Denegadas</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link link-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Registro de Acciones
                            </a>

                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs')}}">ALTAS de Productos</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs-discount')}}">BAJAS de Productos</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link link-dark" href="{{ route('action-logs-admin')}}">Acciones de Administracion</a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-success" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end text-center" aria-labelledby="navbarDropdown">
                                {{ Auth::user()->jobPosition }}
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
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
            @yield('contentFoodRequest')
        </main>
    </div>
</body>

</html>