@extends('layouts.panel')

@section('title', 'Monitores')

@push('styles')
<style>
    /* Estilos personalizados para la paginación en Tema Oscuro */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 0.25rem; /* Espaciado entre los botones */
    }
    
    .custom-pagination .page-link {
        background-color: #212529; /* Fondo oscuro */
        border: 1px solid #495057; /* Borde sutil */
        color: #adb5bd; /* Texto secundario */
        border-radius: 0.5rem !important; /* Bordes redondeados para cada botón */
        padding: 0.375rem 0.75rem;
        transition: all 0.2s ease-in-out;
        font-weight: 500;
    }

    .custom-pagination .page-link:hover {
        background-color: #343a40;
        border-color: #6c757d;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .custom-pagination .page-link:focus {
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        background-color: #343a40;
        color: #ffffff;
    }

    .custom-pagination .page-item.active .page-link {
        background-color: #198754; /* Color success haciendo match con tu botón principal */
        border-color: #198754;
        color: #ffffff;
        box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: #1a1d20;
        border-color: #373b3e;
        color: #6c757d;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="text-light fw-bold mb-1">Monitores</h2>
            <p class="text-secondary mb-0">
                Gestión de monitores académicos
            </p>
        </div>

        <a href="{{ route('monitors.create') }}"
           class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-semibold">
            + Crear Monitor
        </a>
    </div>

    {{-- TABLA --}}
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark">

        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead class="border-bottom border-secondary">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Semestre</th>
                        <th>Asignatura</th>
                        <th class="text-center pe-4">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($monitors as $monitor)
                        <tr>
                            <td class="ps-4 fw-semibold">
                                {{ $monitor->id }}
                            </td>

                            <td>
                                {{ $monitor->user->name ?? 'Sin usuario' }}
                            </td>

                            <td>
                                {{ $monitor->user->email ?? 'Sin correo' }}
                            </td>

                            <td>
                                <span class="badge rounded-pill px-3 py-2
                                    {{ ($monitor->user->estado ?? '') == 'Activo'
                                        ? 'bg-success'
                                        : 'bg-secondary' }}">
                                    {{ $monitor->user->estado ?? 'Sin estado' }}
                                </span>
                            </td>

                            <td>
                                {{ $monitor->semestre }}
                            </td>

                            <td>
                                {{ $monitor->subject->name ?? 'Sin asignatura' }}
                            </td>

                            <td class="text-center pe-4">

                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    {{-- EDITAR --}}
                                    <a href="{{ route('monitors.edit', $monitor->id) }}"
                                       class="btn btn-outline-primary btn-sm rounded-pill px-4 fw-semibold">
                                        Editar
                                    </a>

                                    {{-- ELIMINAR --}}
                                    <form action="{{ route('monitors.destroy', $monitor->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-semibold"
                                                onclick="return confirm('¿Eliminar monitor?')">
                                            Eliminar
                                        </button>
                                    </form>

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-secondary py-5">
                                No hay monitores registrados.
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
                    <strong class="text-light">{{ $monitors->firstItem() ?? 0 }}</strong>
                    a
                    <strong class="text-light">{{ $monitors->lastItem() ?? 0 }}</strong>
                    de
                    <strong class="text-light">{{ $monitors->total() ?? 0 }}</strong>
                    resultados
                </div>

                {{-- PAGINADOR --}}
                <div class="custom-pagination">
                    {{ $monitors->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection