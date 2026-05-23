<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        @include('layouts._dark-theme-styles')
        @stack('styles')
    </head>
    <body class="app-theme">
        <div class="d-flex flex-column min-vh-100">
            <header class="app-topbar text-white shadow-sm border-bottom border-secondary">
                <div class="container py-3 py-lg-4">
                    <h1 class="h2 fw-bold mb-1">Sistema de Gestión de Monitorias</h1>
                    <p class="mb-0">Sede Manizales - Universidad Nacional de Colombia</p>
                </div>
            </header>

            <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
                <div class="container">
                    <a class="navbar-brand fw-semibold" href="{{ route('dashboard') }}">
                        Inicio
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            </li>
                        </ul>

                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="app-main">
                @isset($header)
                    <div class="border-bottom">
                        <div class="container py-4">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <div class="container py-4 py-lg-5">
                    {{ $slot }}
                </div>
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        @stack('scripts')
    </body>
</html>
