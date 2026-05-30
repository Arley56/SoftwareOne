<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Gestión de Monitorias')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('layouts._dark-theme-styles')
    @stack('styles')
</head>

<body class="app-theme">

    <div class="d-flex flex-column min-vh-100">

    <!-- HEADER -->
    <header class="app-topbar text-white shadow">
        <div class="container py-4">
            <h1 class="fw-bold mb-1">
                Sistema de Gestión de Monitorias
            </h1>
            <h5 class="mb-0">
                Sede Manizales - Universidad Nacional de Colombia
            </h5>
        </div>
    </header>

    <!-- NAVBAR OPCIONAL -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                Inicio
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMonitorias">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMonitorias">
                <ul class="navbar-nav ms-auto align-items-lg-center">

                    {{-- Solo ADMIN --}}
                    @if(Auth::user()->role_id == 1)
                        <li class="nav-item">
                            <a href="{{ route('monitors.index') }}" class="nav-link">Monitores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('subjects.index') }}">Materias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('attendances.index') }}">Asistencias</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('monitor-sessions.index') }}">Sesión de Monitorias</a>
                        </li>
                    @endif

                    {{-- ADMIN y MONITOR --}}
                    @if(in_array(Auth::user()->role_id, [1, 2]))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('schedules.index') }}">Horarios</a>
                        </li>
                    @endif

                    {{-- Siempre visible --}}
                    <li class="nav-item dropdown ms-lg-2">
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
                    </li>

                </ul>
            </div>
            </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5 app-main">

        <x-flash-alerts />

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="bg-black text-light text-center py-4 border-top border-secondary mt-auto">
        <div class="container">
            <p class="mb-1 fw-semibold">
                © {{ date('Y') }} Sistema de Gestión de Monitorias
            </p>
            <p class="mb-1">
                Universidad Nacional de Colombia - Sede Manizales
            </p>
            <small class="text-secondary">
                Plataforma académica para la administración de monitorías universitarias
            </small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('layouts._flash-alerts-script')
    @stack('scripts')
    </div>

</body>

</html>