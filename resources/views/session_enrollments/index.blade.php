<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Mis inscripciones</h2>
    </x-slot>

    <div class="card border mb-4">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-0">Monitorías inscritas</h4>
                <small class="text-secondary">Listado de tus inscripciones activas.</small>
            </div>
            <span class="badge text-bg-warning text-dark">{{ $enrollments->total() }} registros</span>
            <p class="text-secondary mb-0">
                Historial de monitorías inscritas.
            </p>
            </div>

            <a
                href="{{ route('session-enrollments.export.pdf') }}"
                target="_blank"
                class="btn btn-danger rounded-pill px-4"
            >
                Exportar PDF
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Monitoría</th>
                        <th>Monitor</th>
                        <th>Horario</th>
                        <th>Fecha sesión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr>
                            <td class="fw-semibold">{{ $enrollment->id }}</td>
                            <td>{{ $enrollment->monitorSession->schedule->monitor->subject->name ?? 'Sin asignatura' }}</td>
                            <td>{{ $enrollment->monitorSession->schedule->monitor->user->name ?? 'Sin monitor' }}</td>
                            <td>
                                {{ $enrollment->monitorSession->schedule->hora_inicio ?? '' }} - {{ $enrollment->monitorSession->schedule->hora_fin ?? '' }}
                            </td>
                            <td>{{ $enrollment->monitorSession->fecha ?? 'Sin fecha' }}</td>
                            <td>
                                @if ($enrollment->status === 'activa')
                                    <span class="badge text-bg-success">Activa</span>
                                @else
                                    <span class="badge text-bg-secondary">Anulada</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('session-enrollments.show', $enrollment->id) }}" class="btn btn-info btn-sm">Ver inscripción</a>

                                    @if ($enrollment->status === 'activa')
                                        <form method="POST" action="{{ route('session-enrollments.destroy', $enrollment->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Deseas anular esta inscripción?')">
                                                Anular inscripción
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-4">
                                Aún no tienes inscripciones activas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer border-top">
            {{ $enrollments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</x-app-layout>
