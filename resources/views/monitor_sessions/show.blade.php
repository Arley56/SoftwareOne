@extends(auth()->user()?->roles?->name === 'Monitor' ? 'layouts.monitor' : 'layouts.panel')

@section('title', 'Detalle sesión')

@section('content')
    <div class="container-fluid">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h2 class="text-light fw-bold mb-1">Detalle de sesión</h2>
                <p class="text-secondary mb-0">
                    Información general de la monitoría seleccionada.
                </p>
            </div>

            @if(auth()->user()?->roles?->name === 'Monitor')
                <a href="{{ route('monitor.dashboard') }}"
                   class="btn btn-outline-light rounded-pill px-4">
                    Volver
                </a>
            @else
                <a href="{{ route('monitor-sessions.index') }}"
                   class="btn btn-outline-light rounded-pill px-4">
                    Volver
                </a>
            @endif
        </div>

        {{-- DETALLE SESIÓN --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark mb-4">

            <div class="card-header bg-dark border-secondary px-4 py-3">
                <h5 class="mb-0 text-light">
                    Tabla: Detalle de sesión
                </h5>
            </div>

            <div class="table-responsive">

                <table class="table table-dark table-bordered mb-0 align-middle">

                    <tbody>

                        <tr>
                            <th style="width: 220px;">ID</th>
                            <td>{{ $session->id }}</td>
                        </tr>

                        <tr>
                            <th>Monitor</th>
                            <td>
                                {{ $session->schedule->monitor->user->name ?? 'Sin monitor' }}

                                <br>

                                <small class="text-secondary">
                                    Sem {{ $session->schedule->monitor->semestre ?? '' }}
                                </small>
                            </td>
                        </tr>

                        <tr>
                            <th>Horario</th>
                            <td>
                                {{ $session->schedule->hora_inicio ?? '' }}
                                -
                                {{ $session->schedule->hora_fin ?? '' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Día</th>

                            <td>
                                @switch($session->schedule->dia_semana ?? 0)

                                    @case(1)
                                        Lunes
                                        @break

                                    @case(2)
                                        Martes
                                        @break

                                    @case(3)
                                        Miércoles
                                        @break

                                    @case(4)
                                        Jueves
                                        @break

                                    @case(5)
                                        Viernes
                                        @break

                                    @case(6)
                                        Sábado
                                        @break

                                    @case(7)
                                        Domingo
                                        @break

                                    @default
                                        No definido

                                @endswitch
                            </td>
                        </tr>

                        <tr>
                            <th>Fecha</th>
                            <td>{{ $session->fecha }}</td>
                        </tr>

                        <tr>
                            <th>Modalidad</th>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst($session->schedule->modalidad ?? '') }}
                                </span>
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        {{-- CARGAR MATERIAL --}}
        @if(auth()->user()?->roles?->name === 'Monitor')

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark mb-4">

                <div class="card-header bg-dark border-secondary px-4 py-3">

                    <div>
                        <h5 class="mb-1 text-light">
                            Cargar material de apoyo
                        </h5>

                        <small class="text-secondary">
                            Sube archivos para complementar la monitoría.
                        </small>
                    </div>

                </div>

                <div class="card-body px-4 py-4">

                    <form
                        action="{{ route('monitor-sessions.materials.store', $session->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        class="d-flex flex-column flex-md-row align-items-md-center gap-3"
                    >

                        @csrf

                        <input
                            type="file"
                            name="material"
                            id="material"
                            class="d-none"
                            onchange="this.form.submit()"
                            required
                        >

                        <label
                            for="material"
                            class="btn btn-success rounded-pill px-4 fw-semibold mb-0"
                        >
                            Cargar material de apoyo
                        </label>

                        <small class="text-secondary">
                            Selecciona el archivo desde tu computador.
                        </small>

                    </form>

                    @error('material')

                        <div class="text-danger small mt-3">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        @endif

        {{-- MATERIAL APOYO --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark mb-4">

            <div class="card-header bg-dark border-secondary px-4 py-3 d-flex justify-content-between align-items-center">

                <div>
                    <h5 class="mb-1 text-light">
                        Material de apoyo
                    </h5>

                    <small class="text-secondary">
                        Archivos cargados para esta monitoría.
                    </small>
                </div>

                <span class="badge bg-info text-dark">
                    {{ $session->sessionMaterials->count() }} archivos
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead class="border-bottom border-secondary">

                        <tr>
                            <th class="ps-4">Archivo</th>
                            <th>Cargado por</th>
                            <th>Fecha</th>
                            <th>Tamaño</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($session->sessionMaterials as $material)

                            <tr>

                                <td class="ps-4 fw-semibold">
                                    {{ $material->original_name }}
                                </td>

                                <td>
                                    {{ $material->uploader->name ?? 'Sin usuario' }}
                                </td>

                                <td>
                                    {{ $material->created_at?->format('d/m/Y H:i') }}
                                </td>

                                <td>

                                    @if($material->size)

                                        {{ number_format($material->size / 1024, 1) }} KB

                                    @else

                                        N/D

                                    @endif

                                </td>

                                <td class="text-end pe-4">

                                    <div class="d-inline-flex gap-2 flex-wrap justify-content-end">

                                        <button
                                            type="button"
                                            class="btn btn-outline-info btn-sm rounded-pill px-3"
                                            data-material-preview
                                            data-name="{{ $material->original_name }}"
                                            data-url="{{ asset('storage/' . $material->file_path) }}"
                                            data-mime="{{ $material->mime_type ?? '' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#materialPreviewModal"
                                        >
                                            Vista previa
                                        </button>

                                        @if(auth()->user()?->roles?->name === 'Monitor')

                                            <form
                                                action="{{ route('monitor-sessions.materials.destroy', [$session->id, $material->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Eliminar archivo?')"
                                                class="d-inline"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm rounded-pill px-3"
                                                >
                                                    Eliminar
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-secondary py-5">

                                    No hay materiales registrados.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- ESTUDIANTES INSCRITOS --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark mb-4">

            <div class="card-header bg-dark border-secondary px-4 py-3 d-flex justify-content-between align-items-center">

                <h5 class="mb-0 text-light">
                    Estudiantes inscritos
                </h5>

                <span class="badge bg-warning text-dark">
                    {{ $session->sessionEnrollments->count() }} inscritos
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead class="border-bottom border-secondary">

                        <tr>
                            <th class="ps-4">Estudiante</th>
                            <th>Correo</th>
                            <th>Estado</th>
                            <th>Inscripción</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($session->sessionEnrollments as $enrollment)

                            <tr>

                                <td class="ps-4 fw-semibold">
                                    {{ $enrollment->user->name ?? 'Sin nombre' }}
                                </td>

                                <td>
                                    {{ $enrollment->user->email ?? 'Sin correo' }}
                                </td>

                                <td>

                                    <span class="badge bg-success text-white">
                                        {{ ucfirst($enrollment->status ?? 'activa') }}
                                    </span>

                                </td>

                                <td>

                                    {{ $enrollment->enrolled_at
                                        ? \Illuminate\Support\Carbon::parse($enrollment->enrolled_at)->format('d/m/Y H:i')
                                        : $enrollment->created_at?->format('d/m/Y H:i')
                                    }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center text-secondary py-5">

                                    No hay estudiantes inscritos.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- ARCHIVOS ESTUDIANTES --}}
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-dark">

            <div class="card-header bg-dark border-secondary px-4 py-3">

                <div>
                    <h5 class="mb-1 text-light">
                        Archivos enviados por estudiantes
                    </h5>

                    <small class="text-secondary">
                        Material adjunto por los estudiantes para la monitoría.
                    </small>
                </div>

            </div>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead class="border-bottom border-secondary">

                        <tr>
                            <th class="ps-4">Estudiante</th>
                            <th>Archivo</th>
                            <th>Fecha</th>
                            <th>Tamaño</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $files = $session->sessionEnrollments
                                ->whereNotNull('student_file');
                        @endphp

                        @forelse($files as $enrollment)

                            <tr>

                                <td class="ps-4 fw-semibold">
                                    {{ $enrollment->user->name ?? 'Sin nombre' }}
                                </td>

                                <td>
                                    {{ basename($enrollment->student_file) }}
                                </td>

                                <td>
                                    {{ $enrollment->updated_at?->format('d/m/Y H:i') }}
                                </td>

                                <td>

                                    @if($enrollment->student_file_size)

                                        {{ number_format($enrollment->student_file_size / 1024, 1) }} KB

                                    @else

                                        N/D

                                    @endif

                                </td>

                                <td class="text-end pe-4">

                                    <button
                                        type="button"
                                        class="btn btn-outline-info btn-sm rounded-pill px-3"
                                        data-material-preview
                                        data-name="{{ basename($enrollment->student_file) }}"
                                        data-url="{{ asset('storage/' . $enrollment->student_file) }}"
                                        data-mime="{{ $enrollment->student_file_mime ?? '' }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#materialPreviewModal"
                                    >
                                        Vista previa
                                    </button>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center text-secondary py-5">

                                    Ningún estudiante ha subido archivos todavía.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if($canViewComments)
            <div class="mt-4">
                @include('session_comments._thread', [
                    'monitorSession' => $session,
                    'comments' => $session->sessionComments,
                    'canComment' => $canComment,
                ])
            </div>
        @endif

        <div class="modal fade" id="materialPreviewModal" tabindex="-1" aria-labelledby="materialPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-light border border-secondary">
                    <div class="modal-header border-secondary">
                        <div>
                            <h5 class="modal-title" id="materialPreviewModalLabel">Vista previa del archivo</h5>
                            <small class="text-secondary" id="materialPreviewSubtitle"></small>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div id="materialPreviewBody" class="bg-black" style="min-height: 55vh;"></div>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const previewBody = document.getElementById('materialPreviewBody');
                    const previewSubtitle = document.getElementById('materialPreviewSubtitle');
                    const previewButtons = document.querySelectorAll('[data-material-preview]');

                    previewButtons.forEach((button) => {
                        button.addEventListener('click', function () {
                            const url = this.dataset.url;
                            const mime = (this.dataset.mime || '').toLowerCase();
                            const name = this.dataset.name || 'Archivo';

                            previewSubtitle.textContent = name;

                            if (mime.startsWith('image/')) {
                                previewBody.innerHTML = `
                                    <div class="d-flex align-items-center justify-content-center p-3" style="min-height: 55vh;">
                                        <img src="${url}" alt="${name}" class="img-fluid rounded shadow-sm" style="max-height: 55vh; object-fit: contain;">
                                    </div>
                                `;
                                return;
                            }

                            if (mime === 'application/pdf' || url.toLowerCase().endsWith('.pdf')) {
                                previewBody.innerHTML = `
                                    <iframe src="${url}" title="${name}" style="width: 100%; height: 55vh; border: 0;"></iframe>
                                `;
                                return;
                            }

                            previewBody.innerHTML = `
                                <div class="d-flex flex-column align-items-center justify-content-center gap-3 p-5 text-center" style="min-height: 55vh;">
                                    <div class="display-6">Vista previa no disponible</div>
                                    <p class="text-secondary mb-0">Este tipo de archivo se abrirá en una nueva pestaña para descargarlo o visualizarlo con la aplicación asociada.</p>
                                    <a href="${url}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-info rounded-pill px-4">
                                        Abrir archivo
                                    </a>
                                </div>
                            `;
                        });
                    });

                    const previewModal = document.getElementById('materialPreviewModal');
                    if (previewModal) {
                        previewModal.addEventListener('hidden.bs.modal', function () {
                            previewBody.innerHTML = '';
                            previewSubtitle.textContent = '';
                        });
                    }
                });
            </script>
        @endpush

    </div>

    @include('session_comments._script')
@endsection