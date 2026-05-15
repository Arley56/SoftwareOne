<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión de Monitorias')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body class="bg-dark text-light">

    <div class="d-flex flex-column min-vh-100">

    <!-- HEADER -->
    <header class="bg-success text-white shadow">
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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a  href="{{ route('monitors.index') }}" class="nav-link">Monitores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subjects.index') }}">Materias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('schedules.index') }}">Horarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('attendances.index') }}">Asistencias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('monitor_sessions.index') }}">Sesión de Monitorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">Roles</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="container my-5 grow">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>

</body>

</html>