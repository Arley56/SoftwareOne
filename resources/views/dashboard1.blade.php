@extends('layouts.panel')

@section('title', 'Dashboard de Administrador')

@section('content')
    <div class="p-4 p-lg-5 rounded-4 mb-4 bg-body-tertiary border border-secondary-subtle shadow-sm text-light">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-success mb-3">Panel de inicio</span>
                <h2 class="display-6 fw-bold mb-3">Sistema de Gestión de Monitorias</h2>
                <p class="lead mb-0 text-secondary">
                    Consulta el estado general del sistema, revisa las sesiones existentes y agenda una monitoria con nosotros.
                </p>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Acceso rápido</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('monitor-sessions.index') }}" class="btn btn-success">Ver sesiones</a>
                            <a href="{{ route('monitors.index') }}" class="btn btn-outline-light">Ver monitores</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Usuarios</div>
                    <div class="fs-2 fw-bold">{{ $totalUsers ?? 0 }}</div>
                    <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-info mt-3">Ver módulo</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Monitores</div>
                    <div class="fs-2 fw-bold">{{ $totalMonitors ?? 0 }}</div>
                    <a href="{{ route('monitors.index') }}" class="btn btn-sm btn-outline-info mt-3">Ver módulo</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Horarios</div>
                    <div class="fs-2 fw-bold">{{ $totalSchedules ?? 0 }}</div>
                    <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-outline-info mt-3">Ver módulo</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Sesiones</div>
                    <div class="fs-2 fw-bold">{{ $totalSessions ?? 0 }}</div>
                    <a href="{{ route('monitor-sessions.index') }}" class="btn btn-sm btn-outline-info mt-3">Ver módulo</a>
                </div>
            </div>
        </div>
    </div>

    <div id="dashboard-sessions-wrapper">
        @include('dashboard._sessions', ['sessions' => $sessions])
    </div>

    <div class="card bg-dark text-white border-secondary shadow-sm">
        <div class="card-header border-secondary">
            <h4 class="mb-0">Últimas asistencias</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Sesión</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAttendances ?? [] as $attendance)
                        <tr>
                            <td>{{ $attendance->id }}</td>
                            <td>{{ optional($attendance->user)->name ?? 'Sin usuario' }}</td>
                            <td>{{ $attendance->monitor_session_id }}</td>
                            <td>
                                @if($attendance->asistio == 'present')
                                    <span class="badge bg-success">Presente</span>
                                @elseif($attendance->asistio == 'absent')
                                    <span class="badge bg-danger">Ausente</span>
                                @else
                                    <span class="badge bg-warning text-dark">Justificado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-secondary py-4">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        (() => {
            const wrapper = document.getElementById('dashboard-sessions-wrapper');

            if (!wrapper) {
                return;
            }

            const storageKey = 'dashboard-session-scroll-y';
            const baseUrl = "{{ route('dashboard') }}";

            const buildUrl = (query = {}) => {
                const url = new URL(baseUrl, window.location.origin);

                Object.entries(query).forEach(([key, value]) => {
                    if (value !== null && value !== undefined && String(value).trim() !== '') {
                        url.searchParams.set(key, value);
                    }
                });

                return url.toString();
            };

            const loadSessions = async (url, pushState = true) => {
                sessionStorage.setItem(storageKey, String(window.scrollY));

                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    window.location.href = url;
                    return;
                }

                const data = await response.json();
                wrapper.innerHTML = data.html;

                if (pushState) {
                    window.history.pushState({ url }, '', data.url || url);
                }

                const savedScrollY = sessionStorage.getItem(storageKey);

                if (savedScrollY !== null) {
                    window.scrollTo(0, Number(savedScrollY));
                    sessionStorage.removeItem(storageKey);
                }
            };

            document.addEventListener('submit', (event) => {
                const form = event.target;

                if (!(form instanceof HTMLFormElement) || form.id !== 'dashboard-filters') {
                    return;
                }

                event.preventDefault();

                const formData = new FormData(form);

                loadSessions(buildUrl({
                    subject: formData.get('subject'),
                    monitor: formData.get('monitor'),
                    fecha: formData.get('fecha'),
                }));
            });

            document.addEventListener('click', (event) => {
                const target = event.target;

                if (!(target instanceof Element)) {
                    return;
                }

                const resetButton = target.closest('#dashboard-reset');
                if (resetButton) {
                    event.preventDefault();
                    loadSessions(baseUrl);
                    return;
                }

                const paginationLink = target.closest('#dashboard-sessions-wrapper .pagination a');

                if (paginationLink) {
                    event.preventDefault();
                    loadSessions(paginationLink.href);
                }
            });

            window.addEventListener('popstate', () => {
                loadSessions(window.location.href, false);
            });

            const savedScrollY = sessionStorage.getItem(storageKey);

            if (savedScrollY !== null) {
                window.scrollTo(0, Number(savedScrollY));
                sessionStorage.removeItem(storageKey);
            }
        })();
    </script>
@endsection