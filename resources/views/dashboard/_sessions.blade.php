@php
    $enrolledSessionIds = $enrolledSessionIds ?? [];
    $enrollmentMap = $enrollmentMap ?? [];
@endphp

<div class="card border mb-4" id="dashboard-sessions-card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Monitorías disponibles</h4>
            <small class="text-secondary">Filtra las monitorías por asignatura, monitor o fecha.</small>
        </div>
        <span class="badge text-bg-warning text-dark">{{ $sessions->total() }} resultados</span>
    </div>
    <div class="card-body border-bottom">
        <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end" id="dashboard-filters">
            <div class="col-md-4">
                <label for="subject" class="form-label">Monitoria</label>
                <input type="text" name="subject" id="subject" class="form-control" value="{{ request('subject') }}" placeholder="Nombre de la monitoria">
            </div>
            <div class="col-md-4">
                <label for="monitor" class="form-label">Monitor</label>
                <input type="text" name="monitor" id="monitor" class="form-control" value="{{ request('monitor') }}" placeholder="Nombre del monitor">
            </div>
            <div class="col-md-4">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ request('fecha') }}">
            </div>
            <div class="col-12 d-flex gap-2 flex-wrap">
                <button type="submit" class="btn btn-success">Filtrar</button>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" id="dashboard-reset">Limpiar</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-dark table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th>Sesión</th>
                    <th>Monitoria</th>
                    <th>Monitor</th>
                    <th>Horario</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sessions as $session)
                    <tr>
                        <td class="fw-semibold">#{{ $session->id }}</td>
                        <td>{{ $session->schedule->monitor->subject->name ?? 'Sin asignatura' }}</td>
                        <td>{{ $session->schedule->monitor->user->name ?? 'Sin monitor' }}</td>
                        <td>{{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}</td>
                        <td>{{ $session->fecha }}</td>
                        <td>
                            @if (auth()->user()?->roles?->name === 'Administrador')
                                <a href="{{ route('monitor-sessions.show', $session->id) }}" class="btn btn-info btn-sm">Ver</a>
                            @else
                                @if (in_array($session->id, $enrolledSessionIds))
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge text-bg-success">Inscrito</span>
                                        @if (isset($enrollmentMap[$session->id]))
                                            <a href="{{ route('session-enrollments.show', $enrollmentMap[$session->id]) }}" class="btn btn-outline-info btn-sm">Ver inscripción</a>
                                        @endif
                                    </div>
                                @else
                                    <button
                                        type="button"
                                        class="btn btn-primary btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#enrollModal{{ $session->id }}"
                                    >
                                        Inscribirme
                                    </button>

                                    <div class="modal fade" id="enrollModal{{ $session->id }}" tabindex="-1" aria-labelledby="enrollModalLabel{{ $session->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-light border-secondary">
                                                <div class="modal-header border-secondary">
                                                    <h5 class="modal-title" id="enrollModalLabel{{ $session->id }}">Confirmar inscripción</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-3">¿Quieres inscribirte en esta monitoría?</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item bg-dark text-light border-secondary"><strong>Monitoría:</strong> {{ $session->schedule->monitor->subject->name ?? 'Sin asignatura' }}</li>
                                                        <li class="list-group-item bg-dark text-light border-secondary"><strong>Monitor:</strong> {{ $session->schedule->monitor->user->name ?? 'Sin monitor' }}</li>
                                                        <li class="list-group-item bg-dark text-light border-secondary"><strong>Horario:</strong> {{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}</li>
                                                        <li class="list-group-item bg-dark text-light border-secondary"><strong>Fecha:</strong> {{ $session->fecha }}</li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer border-secondary">
                                                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="POST" action="{{ route('monitor-sessions.enrollments.store', $session->id) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary">Aceptar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">
                            No hay sesiones que coincidan con el filtro.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer border-top">
        {{ $sessions->links('pagination::bootstrap-5') }}
    </div>
</div>