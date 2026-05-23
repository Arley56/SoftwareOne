@extends('layouts.monitor')

@section('title', 'Panel de Monitor')

@section('content')
    <div class="p-4 p-lg-5 rounded-4 mb-4 bg-body-tertiary border border-secondary-subtle shadow-sm text-light">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="badge text-bg-success mb-3">Inicio de monitor</span>
                <h2 class="display-6 fw-bold mb-3">{{ $monitor->user->name ?? auth()->user()->name }}</h2>
                <p class="lead mb-0 text-secondary">
                    {{ $monitor->subject->name ?? 'Sin materia asignada' }} · Semestre {{ $monitor->semestre ?? 'Sin dato' }}
                </p>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Acceso rápido</h5>
                        <div class="d-grid gap-2">
                            <a href="#today-board" class="btn btn-success">Ver citas de hoy</a>
                            <a href="#month-board" class="btn btn-outline-light">Ver citas del mes</a>
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
                    <div class="text-secondary text-uppercase small">Citas de hoy</div>
                    <div class="fs-2 fw-bold">{{ $todaySessionsCount }}</div>
                    <small class="text-secondary">Sesiones programadas para esta fecha.</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Citas del mes</div>
                    <div class="fs-2 fw-bold">{{ $monthSessionsCount }}</div>
                    <small class="text-secondary">Sesiones en el mes actual.</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Inscripciones activas</div>
                    <div class="fs-2 fw-bold">{{ $activeEnrollmentsCount }}</div>
                    <small class="text-secondary">Total acumulado en sesiones del mes.</small>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-dark text-white border-secondary h-100">
                <div class="card-body">
                    <div class="text-secondary text-uppercase small">Retroalimentaciones</div>
                    <div class="fs-2 fw-bold">{{ $feedbacksCount }}</div>
                    <small class="text-secondary">Opiniones registradas en el mes.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card bg-dark text-white border-secondary shadow-sm h-100" id="today-board">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Citas del día</h4>
                    <span class="badge text-bg-info text-dark">{{ $todaySessionsCount }} registros</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Monitoría</th>
                                <th>Inscritos</th>
                                <th>Asistencias</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todaySessions as $session)
                                <tr>
                                    <td>{{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $session->schedule->monitor->subject->name ?? 'Sin asignatura' }}</div>
                                        <small class="text-secondary">{{ $session->schedule->modalidad ?? 'Sin modalidad' }}</small>
                                    </td>
                                    <td>{{ $session->active_enrollments_count ?? 0 }}</td>
                                    <td>{{ $session->attendances_count ?? 0 }}</td>
                                    <td>
                                        <a href="{{ route('monitor-sessions.show', $session->id) }}" class="btn btn-info btn-sm">Ver sesión</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-secondary py-4">No hay citas programadas para hoy.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-dark text-white border-secondary shadow-sm h-100">
                <div class="card-header border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h4 class="mb-0">Próximas citas</h4>
                    <span class="badge text-bg-warning text-dark">Agenda</span>
                </div>
                <div class="list-group list-group-flush">
                    @forelse ($upcomingSessions as $session)
                        <div class="list-group-item bg-dark text-light border-secondary">
                            <div class="fw-semibold">{{ $session->monitorSession?->schedule?->monitor?->subject?->name ?? $session->schedule->monitor->subject->name ?? 'Sin asignatura' }}</div>
                            <small class="text-secondary d-block">{{ $session->fecha }} · {{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}</small>
                            <small class="text-secondary d-block">{{ $session->active_enrollments_count ?? 0 }} inscritos activos</small>
                        </div>
                    @empty
                        <div class="list-group-item bg-dark text-light border-secondary text-secondary">
                            No tienes citas próximas.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white border-secondary shadow-sm" id="month-board">
        <div class="card-header border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h4 class="mb-0">Citas del mes</h4>
            <span class="badge text-bg-success">{{ $monthSessionsCount }} registros</span>
        </div>
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Monitoría</th>
                        <th>Inscritos</th>
                        <th>Asistencias</th>
                        <th>Retroalimentaciones</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($monthSessions as $session)
                        <tr>
                            <td>{{ $session->fecha }}</td>
                            <td>{{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}</td>
                            <td>{{ $session->schedule->monitor->subject->name ?? 'Sin asignatura' }}</td>
                            <td>{{ $session->active_enrollments_count ?? 0 }}</td>
                            <td>{{ $session->attendances_count ?? 0 }}</td>
                            <td>{{ $session->feedbacks_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('monitor-sessions.show', $session->id) }}" class="btn btn-outline-info btn-sm">Ver sesión</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">No hay citas registradas en este mes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection