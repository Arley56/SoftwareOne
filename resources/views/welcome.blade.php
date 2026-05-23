<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('title', 'Sistema · Monitorias Académicas')</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            :root {
                --page-bg: #0d1117;
                --page-surface: #161b22;
                --page-surface-soft: #1f2630;
                --page-text: #e6edf3;
                --page-muted: #9aa4b2;
                --page-accent: #1f8f55;
                --page-accent-soft: #f0b429;
            }

            html, body {
                min-height: 100%;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background:
                    radial-gradient(circle at top left, rgba(31, 143, 85, 0.18), transparent 28%),
                    radial-gradient(circle at bottom right, rgba(240, 180, 41, 0.10), transparent 24%),
                    var(--page-bg);
                color: var(--page-text);
            }

            .topbar {
                background: linear-gradient(90deg, #0f5132, #1f8f55);
            }

            .navband {
                background: #05070a;
            }

            .hero-shell {
                background: rgba(22, 27, 34, 0.88);
                border: 1px solid rgba(154, 164, 178, 0.15);
                backdrop-filter: blur(10px);
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.45));
            }

            .soft-card {
                background: rgba(31, 38, 48, 0.92);
                border: 1px solid rgba(154, 164, 178, 0.14);
            }

            .soft-panel {
                background: rgba(15, 20, 27, 0.92);
                border: 1px solid rgba(154, 164, 178, 0.12);
            }

            .section-title {
                letter-spacing: -0.02em;
            }
        </style>
    </head>
    <body class="d-flex flex-column min-vh-100">
        <header class="topbar text-white shadow-sm">
            <div class="container py-3 py-lg-4">
                <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3">
                    <div>
                        <h1 class="display-6 fw-bold mb-1">Sistema de Gestión de Monitorías</h1>
                        <p class="mb-0 fw-semibold">Sede Manizales - Universidad Nacional de Colombia</p>
                    </div>

                    @if (Route::has('login'))
                        <div class="d-flex align-items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-warning btn-sm rounded-pill px-3 text-dark">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </header>

        <main class="container flex-grow-1 pt-4 pt-lg-5 pb-5">
            <section class="hero-shell rounded-4 p-4 p-lg-5 shadow-sm mb-4">
                <div id="welcomeCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row align-items-center g-4">
                                <div class="col-lg-7">
                                    <span class="badge text-bg-warning rounded-pill mb-3">Plataforma académica</span>
                                    <h1 class="display-5 fw-bold section-title mb-3">Bienvenido al sistema de monitorías</h1>
                                    <p class="lead text-secondary mb-4">Consulta horarios, solicita acompañamiento y organiza tus sesiones desde un solo lugar.</p>

                                </div>

                                <div class="col-lg-5">
                                    <div class="soft-card rounded-4 p-4 h-100">
                                        <h2 class="h5 fw-semibold mb-3">Agenda rápida</h2>
                                        <ul class="list-unstyled mb-0 d-grid gap-3">
                                            <li class="d-flex gap-3">
                                                <span class="badge rounded-pill text-bg-dark align-self-start">1</span>
                                                <div>
                                                    <div class="fw-semibold">Reserva una sesión</div>
                                                    <small class="text-secondary">Elige materia, monitor y horario disponible.</small>
                                                </div>
                                            </li>
                                            <li class="d-flex gap-3">
                                                <span class="badge rounded-pill text-bg-dark align-self-start">2</span>
                                                <div>
                                                    <div class="fw-semibold">Confirma asistencia</div>
                                                    <small class="text-secondary">Recibe el detalle de tu monitoría en segundos.</small>
                                                </div>
                                            </li>
                                            <li class="d-flex gap-3">
                                                <span class="badge rounded-pill text-bg-dark align-self-start">3</span>
                                                <div>
                                                    <div class="fw-semibold">Sigue tu progreso</div>
                                                    <small class="text-secondary">Lleva control de sesiones y seguimiento académico.</small>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="row align-items-center g-4 py-2 py-lg-3">
                                <div class="col-lg-6">
                                    <span class="badge text-bg-warning rounded-pill mb-3">Plataforma académica</span>
                                    <h2 class="display-6 fw-bold section-title mb-3">Apoyo en materias clave</h2>
                                    <p class="text-secondary mb-0">Encuentra acompañamiento en matemáticas, programación, física y más, con disponibilidad organizada.</p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="soft-card rounded-4 p-4">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="p-3 rounded-4 soft-panel h-100">
                                                    <div class="fw-semibold">Matemáticas</div>
                                                    <small class="text-secondary">Álgebra, cálculo y estadística.</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-3 rounded-4 soft-panel h-100">
                                                    <div class="fw-semibold">Programación</div>
                                                    <small class="text-secondary">Lógica, bases y proyectos.</small>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="p-3 rounded-4 soft-panel">
                                                    <div class="fw-semibold">Horarios flexibles</div>
                                                    <small class="text-secondary">Sesiones presenciales y remotas según disponibilidad.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="row align-items-center g-4 py-2 py-lg-3">
                                <div class="col-lg-6">
                                    <span class="badge text-bg-warning rounded-pill mb-3">Plataforma académica</span>
                                    <h2 class="display-6 fw-bold section-title mb-3">Gestión simple y ordenada</h2>
                                    <p class="text-secondary mb-0">Solicitudes, asistencia y retroalimentación en una interfaz clara para estudiantes y monitores.</p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="soft-card rounded-4 p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="fw-semibold">Estado de la sesión</span>
                                            <span class="badge text-bg-success">Activa</span>
                                        </div>
                                        <div class="progress mb-3" style="height: 10px;">
                                            <div class="progress-bar bg-warning" style="width: 72%"></div>
                                        </div>
                                        <small class="text-secondary">El sistema centraliza la información para que no pierdas seguimiento.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Anterior</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#welcomeCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Siguiente</span>
                    </button>
                </div>
            </section>

            <section id="monitores" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="soft-card rounded-4 p-4 h-100">
                            <h3 class="h5 fw-semibold">Monitores destacados</h3>
                            <p class="text-secondary mb-0">Consulta perfiles, materias y disponibilidad sin salir de la vista principal.</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="soft-card rounded-4 p-4 h-100">
                            <h3 class="h5 fw-semibold">Solicitudes rápidas</h3>
                            <p class="text-secondary mb-0">Envía una petición y revisa el estado desde el panel cuando entres al sistema.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="horarios" class="mb-4">
                <div class="soft-card rounded-4 p-4">
                    <h3 class="h5 fw-semibold mb-2">Horarios disponibles</h3>
                    <p class="text-secondary mb-0">Los bloques de atención se organizan para facilitar el acceso a monitorías según tu tiempo libre.</p>
                </div>
            </section>
        </main>

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

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>