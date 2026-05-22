<div class="card bg-dark text-white border-secondary mb-4 shadow-sm" id="dashboard-sessions-card">
    <div class="card-header border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="mb-0">Sesiones existentes</h4>
            <small class="text-secondary">Filtra las monitorias por asignatura, monitor o fecha.</small>
        </div>
        <span class="badge text-bg-secondary">{{ $sessions->total() }} resultados</span>
    </div>
    <div class="card-body border-bottom border-secondary">
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
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light" id="dashboard-reset">Limpiar</a>
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
                            <a href="{{ route('monitor-sessions.show', $session->id) }}" class="btn btn-info btn-sm">Ver</a>
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
    <div class="card-footer border-secondary bg-transparent">
        {{ $sessions->links('pagination::bootstrap-5') }}
    </div>
</div>