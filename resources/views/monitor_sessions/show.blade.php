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

        @if(session('status'))
            <div class="alert alert-success border-0 shadow-sm">
                {{ session('status') }}
            </div>
        @endif

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

                                        <a
                                            href="{{ asset('storage/' . $material->file_path) }}"
                                            target="_blank"
                                            class="btn btn-outline-info btn-sm rounded-pill px-3"
                                        >
                                            Ver
                                        </a>

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

                                    <a
                                        href="{{ asset('storage/' . $enrollment->student_file) }}"
                                        target="_blank"
                                        class="btn btn-outline-info btn-sm rounded-pill px-3"
                                    >
                                        Ver archivo
                                    </a>

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

    </div>
@endsection