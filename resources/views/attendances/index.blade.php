@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1>Asistencias</h1>

        <a href="{{ route('attendances.create') }}" class="btn btn-primary mb-3">
            Nueva asistencia
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Sesión</th>
                    <th>Estado de asistencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->id }}</td>

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
                                <span class="badge bg-success">Presente</span>

                            @elseif(in_array($estado, ['absent', 'ausente']))
                                <span class="badge bg-danger">Ausente</span>

                            @elseif(in_array($estado, ['justified', 'justificado']))
                                <span class="badge bg-warning text-dark">Justificado</span>

                            @else
                                <span class="badge bg-secondary">Sin estado</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('attendances.show', $attendance->id) }}" class="btn btn-info btn-sm">
                                Ver
                            </a>

                            <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar esta asistencia?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection