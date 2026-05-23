<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Monitor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('layouts._dark-theme-styles')
    @stack('styles')
</head>

<body class="app-theme">
    <div class="d-flex flex-column min-vh-100">
        <header class="app-topbar text-white shadow-sm border-bottom border-secondary">
            <div class="container py-3 py-lg-4">
                <h1 class="h2 fw-bold mb-1">Panel del Monitor</h1>
                <p class="mb-0">Sistema de Gestión de Monitorias - Sede Manizales</p>
            </div>
        </header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
            <div class="container">
                <a class="navbar-brand fw-semibold" href="{{ route('monitor.dashboard') }}">Resumen</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#monitorNavbar" aria-controls="monitorNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="monitorNavbar">
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link" href="#today-board">Citas de hoy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#month-board">Citas del mes</a>
                        </li>
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

        <main class="app-main flex-grow-1">
            <div class="container py-4 py-lg-5">
                @yield('content')
            </div>
        </main>

        <footer class="bg-black text-light text-center py-4 border-top border-secondary mt-auto">
            <div class="container">
                <p class="mb-1 fw-semibold">© {{ date('Y') }} Sistema de Gestión de Monitorias</p>
                <small class="text-secondary">Panel operativo para monitores</small>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>