@extends('layouts.panel')

@section('title', 'Asistencias')

@push('styles')
<style>
    /* TABLA UNIFORME */
    .uniform-table thead th {
        border-bottom: 1px solid rgba(255,255,255,0.08);
        color: #cbd5e1;
        font-weight: 600;
    }

    .uniform-table tbody td {
        vertical-align: middle;
        padding: 0.85rem 1rem;
        color: #e9ecef;
    }

    .uniform-table.table-hover tbody tr:hover {
        background-color: rgba(255,255,255,0.02);
        transform: translateY(-1px);
    }

    .uniform-table .ps-4 { padding-left: 1.25rem !important; }

    /* BOTONES DE ACCIÓN UNIFORMES */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .action-buttons .btn {
        border-radius: 0.5rem;
        padding: 0.375rem 0.9rem;
        font-weight: 600;
        min-width: 92px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    /* Mantener proporción entre botones primario y peligro */
    .btn-outline-primary,
    .btn-outline-danger,
    .btn-outline-success {
        border-width: 1px;
        padding: 0.375rem 0.9rem;
        border-radius: 0.5rem;
    }

    /* Alineación consistente para controles del encabezado */
    .page-header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    /* PAGINACIÓN CONSISTENTE (Tema oscuro) */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem;
    }

    .custom-pagination .page-link {
        background-color: #212529;
        border: 1px solid #495057;
        color: #adb5bd;
        border-radius: 0.5rem !important;
        padding: 0.375rem 0.75rem;
        transition: all 0.15s ease-in-out;
        font-weight: 500;
    }

    .custom-pagination .page-link:hover {
        background-color: #343a40;
        border-color: #6c757d;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #198754;
        border-color: #198754;
        color: #ffffff;
        box-shadow: 0 4px 6px rgba(25,135,84,0.18);
    }

    .custom-empty-state {
        color: #adb5bd;
        padding: 3.5rem 1rem;
    }

</style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
            <div>
                <h2 class="text-light fw-bold mb-1">Asistencias</h2>
                <p class="text-secondary mb-0">
                    Gestión de asistencias
                </p>
            </div>

            <a href="{{ route('attendances.create') }}"
            class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-semibold">
                + Nueva asistencia
            </a>
        </div>

        {{-- TABLA --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark">
            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead class="border-bottom border-secondary">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Usuario</th>
                            <th>Sesión</th>
                            <th>Estado de asistencia</th>
                            <th class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($attendances as $attendance)

                            <tr>

                                <td class="ps-4 fw-semibold">
                                    {{ $attendance->id }}
                                </td>

                                <td>
                                    {{ $attendance->user->name ?? 'Sin usuario' }}
                                </td>

                                <td>
                                    Sesión #{{ $attendance->monitorSession->id ?? 'Sin sesión' }}
                                </td>

                                <td>

                                    @php
                                        $estado = strtolower($attendance->asistio);
                                    @endphp

                                    @if(in_array($estado, ['present', 'presente']))

                                        <span class="badge rounded-pill px-3 py-2 bg-success">
                                            Presente
                                        </span>

                                    @elseif(in_array($estado, ['absent', 'ausente']))

                                        <span class="badge rounded-pill px-3 py-2 bg-danger">
                                            Ausente
                                        </span>

                                    @elseif(in_array($estado, ['justified', 'justificado']))

                                        <span class="badge rounded-pill px-3 py-2 bg-warning text-dark">
                                            Justificado
                                        </span>

                                    @else

                                        <span class="badge rounded-pill px-3 py-2 bg-secondary">
                                            Sin estado
                                        </span>

                                    @endif

                                </td>

                                <td class="text-center pe-4">

                                    <div class="d-flex justify-content-center gap-2 flex-wrap">

                                        {{-- VER --}}
                                        <a href="{{ route('attendances.show', $attendance->id) }}"
                                        class="btn btn-info btn-sm rounded-pill px-4 fw-semibold">
                                            Ver
                                        </a>

                                        {{-- EDITAR --}}
                                        <a href="{{ route('attendances.edit', $attendance->id) }}"
                                        class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                                            Editar
                                        </a>

                                        {{-- ELIMINAR --}}
                                        <form action="{{ route('attendances.destroy', $attendance->id) }}"
                                            method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-semibold"
                                                    onclick="return confirm('¿Eliminar esta asistencia?')">
                                                Eliminar
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">
                                    No hay asistencias registradas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>
            {{-- PAGINACIÓN MEJORADA --}}
            <div class="bg-dark border-top border-secondary px-4 py-3">

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">

                    {{-- TEXTO --}}
                    <div class="text-secondary small">
                        Mostrando
                        {{ $attendances->firstItem() ?? 0 }}
                        a
                        {{ $attendances->lastItem() ?? 0 }}
                        de
                        <strong class="text-light">{{ $attendances->total() ?? 0 }}</strong>
                        resultados
                    </div>

                    {{-- PAGINADOR --}}
                    <div class="custom-pagination">
                        {{ $attendances->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection