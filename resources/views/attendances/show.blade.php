@extends('layouts.panel')

@section('content')
<div class="container">
    <h1>Detalle de asistencia</h1>

    <div class="card mt-3">
        <div class="card-body">

            <p><strong>ID:</strong> {{ $attendance->id }}</p>

            <p><strong>Usuario:</strong>
                {{ optional($attendance->user)->name ?? 'Sin usuario' }}
            </p>

            <p><strong>Sesión:</strong>
                {{ $attendance->monitor_session_id }}
            </p>

            <p><strong>Asistencia:</strong>
                @switch($attendance->asistio)
                    @case('present')
                        <span class="badge bg-success">Presente</span>
                        @break

                    @case('absent')
                        <span class="badge bg-danger">Ausente</span>
                        @break

                    @case('justified')
                        <span class="badge bg-warning text-dark">Justificado</span>
                        @break

                    @default
                        <span class="badge bg-secondary">Sin estado</span>
                @endswitch
            </p>

            <p><strong>Creado:</strong> {{ $attendance->created_at }}</p>

        </div>
    </div>

    <a href="{{ route('attendances.index') }}" class="btn btn-secondary mt-3">
        Volver
    </a>
</div>
@endsection