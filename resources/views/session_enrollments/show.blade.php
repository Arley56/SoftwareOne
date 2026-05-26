<x-app-layout>
    <x-slot name="header">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="h4 mb-0">Detalle de inscripción</h2>

                <p class="text-secondary mb-0">
                    Consulta la información de la monitoría y el material compartido por el monitor.
                </p>
            </div>

            <a href="{{ route('session-enrollments.index') }}" class="btn btn-outline-light">
                Volver
            </a>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-dark text-light mb-4">

        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2 border-secondary">

            <h4 class="mb-0">
                Inscripción #{{ $sessionEnrollment->id }}
            </h4>

            @if ($sessionEnrollment->status === 'activa')

                <span class="badge text-bg-success">
                    Activa
                </span>

            @else

                <span class="badge text-bg-secondary">
                    Anulada
                </span>

            @endif

        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Estudiante
                    </h6>

                    <p class="mb-0">
                        {{ $sessionEnrollment->user->name ?? 'Sin dato' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Monitoría
                    </h6>

                    <p class="mb-0">
                        {{ $sessionEnrollment->monitorSession->schedule->monitor->subject->name ?? 'Sin asignatura' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Monitor
                    </h6>

                    <p class="mb-0">
                        {{ $sessionEnrollment->monitorSession->schedule->monitor->user->name ?? 'Sin monitor' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Fecha de sesión
                    </h6>

                    <p class="mb-0">
                        {{ $sessionEnrollment->monitorSession->fecha ?? 'Sin fecha' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Horario
                    </h6>

                    <p class="mb-0">
                        {{ $sessionEnrollment->monitorSession->schedule->hora_inicio ?? '' }}
                        -
                        {{ $sessionEnrollment->monitorSession->schedule->hora_fin ?? '' }}
                    </p>

                </div>

                <div class="col-md-6">

                    <h6 class="text-secondary mb-1">
                        Fecha de inscripción
                    </h6>

                    <p class="mb-0">
                        {{ optional($sessionEnrollment->enrolled_at)->format('Y-m-d H:i') ?? 'Sin registro' }}
                    </p>

                </div>

            </div>

        </div>

        <div class="card-footer d-flex gap-2 flex-wrap border-secondary">

            @if ($sessionEnrollment->status === 'activa' && auth()->id() === $sessionEnrollment->user_id)

                <form
                    method="POST"
                    action="{{ route('session-enrollments.destroy', $sessionEnrollment->id) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="btn btn-outline-danger"
                        onclick="return confirm('¿Deseas anular esta inscripción?')"
                    >
                        Anular inscripción
                    </button>

                </form>

            @endif

        </div>

    </div>

    {{-- SUBIR EJERCICIO --}}
    <div class="card border-0 shadow-sm bg-dark text-light mb-4">

        <div class="card-header border-secondary">

            <h4 class="mb-0">
                Adjuntar ejercicio
            </h4>

            <small class="text-secondary">
                Puedes subir archivos PDF o JPG con un tamaño máximo de 10 MB.
            </small>

        </div>

        <div class="card-body">

            <form
                action="{{ route('session-enrollments.upload-exercise', $sessionEnrollment->id) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Archivo
                    </label>

                    <input
                        type="file"
                        name="exercise_file"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png"
                        required
                    >

                    @error('exercise_file')

                        <div class="text-danger mt-2">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <button type="submit" class="btn btn-success">
                    Subir archivo
                </button>

            </form>

        </div>

    </div>

    {{-- ARCHIVOS SUBIDOS POR EL ESTUDIANTE --}}
    <div class="card border-0 shadow-sm bg-dark text-light mb-4">

        <div class="card-header border-secondary d-flex justify-content-between align-items-center">

            <div>

                <h4 class="mb-0">
                    Mis ejercicios enviados
                </h4>

                <small class="text-secondary">
                    Archivos que has compartido para la monitoría.
                </small>

            </div>

            <span class="badge text-bg-warning text-dark">
                {{ $sessionEnrollment->sessionExercises->count() }}
                archivos
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-dark table-hover align-middle mb-0">

                <thead class="border-bottom border-secondary">

                    <tr>

                        <th class="ps-4">
                            Archivo
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Tamaño
                        </th>

                        <th class="text-end pe-4">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($sessionEnrollment->sessionExercises as $exercise)

                        <tr>

                            <td class="ps-4 fw-semibold">
                                {{ $exercise->original_name }}
                            </td>

                            <td>
                                {{ $exercise->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                @if ($exercise->size)

                                    {{ number_format($exercise->size / 1024, 1) }} KB

                                @else

                                    N/D

                                @endif

                            </td>

                            <td class="text-end pe-4">

                                <button
                                    type="button"
                                    class="btn btn-outline-info btn-sm rounded-pill px-3"
                                    data-material-preview
                                    data-name="{{ $exercise->original_name }}"
                                    data-url="{{ asset('storage/' . $exercise->file_path) }}"
                                    data-mime="{{ $exercise->mime_type ?? '' }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#materialPreviewModal"
                                >
                                    Vista previa
                                </button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center text-secondary py-5">
                                Todavía no has subido ejercicios.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- MATERIAL DEL MONITOR --}}
    @if ($sessionEnrollment->status === 'activa')

        <div class="card border-0 shadow-sm bg-dark text-light mb-4">

            <div class="card-header border-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">

                <div>

                    <h4 class="mb-0">
                        Material de apoyo
                    </h4>

                    <small class="text-secondary">
                        Material compartido por el monitor para esta monitoría.
                    </small>

                </div>

                <span class="badge text-bg-info text-dark">
                    {{ $sessionEnrollment->monitorSession->sessionMaterials->count() }}
                    archivos
                </span>

            </div>

            <div class="table-responsive">

                <table class="table table-dark table-hover align-middle mb-0">

                    <thead class="border-bottom border-secondary">

                        <tr>

                            <th class="ps-4">
                                Archivo
                            </th>

                            <th>
                                Cargado por
                            </th>

                            <th>
                                Fecha
                            </th>

                            <th>
                                Tamaño
                            </th>

                            <th class="text-end pe-4">
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($sessionEnrollment->monitorSession->sessionMaterials as $material)

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

                                    @if ($material->size)

                                        {{ number_format($material->size / 1024, 1) }} KB

                                    @else

                                        N/D

                                    @endif

                                </td>

                                <td class="text-end pe-4">

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

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center text-secondary py-5">
                                    Todavía no se ha cargado material de apoyo para esta monitoría.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @endif

    {{-- MODAL --}}
    <div
        class="modal fade"
        id="materialPreviewModal"
        tabindex="-1"
        aria-labelledby="materialPreviewModalLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered modal-xl">

            <div class="modal-content bg-dark text-light border border-secondary">

                <div class="modal-header border-secondary">

                    <div>

                        <h5 class="modal-title" id="materialPreviewModalLabel">
                            Vista previa del archivo
                        </h5>

                        <small class="text-secondary" id="materialPreviewSubtitle"></small>

                    </div>

                    <button
                        type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"
                    ></button>

                </div>

                <div class="modal-body p-0">

                    <div
                        id="materialPreviewBody"
                        class="bg-black"
                        style="min-height: 70vh;"
                    ></div>

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
                                <div class="d-flex align-items-center justify-content-center p-3" style="min-height: 70vh;">
                                    <img src="${url}" alt="${name}" class="img-fluid rounded shadow-sm" style="max-height: 70vh; object-fit: contain;">
                                </div>
                            `;

                            return;

                        }

                        if (mime === 'application/pdf' || url.toLowerCase().endsWith('.pdf')) {

                            previewBody.innerHTML = `
                                <iframe src="${url}" title="${name}" style="width: 100%; height: 70vh; border: 0;"></iframe>
                            `;

                            return;

                        }

                        previewBody.innerHTML = `
                            <div class="d-flex flex-column align-items-center justify-content-center gap-3 p-5 text-center" style="min-height: 70vh;">
                                <div class="display-6">Vista previa no disponible</div>
                                <p class="text-secondary mb-0">
                                    Este tipo de archivo se abrirá en una nueva pestaña para descargarlo o visualizarlo con la aplicación asociada.
                                </p>
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

</x-app-layout>