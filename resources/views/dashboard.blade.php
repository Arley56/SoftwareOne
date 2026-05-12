@extends('layouts.panel')

@section('title', 'Dashboard')

@section('content')

    <h2 class="text-light">Panel Principal</h2>

    {{-- RESUMEN EN TABLA (MISMO ESTILO QUE USERS) --}}
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Total</th>
                <th>Acción</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Usuarios</td>
                <td>{{ $totalUsers ?? 0 }}</td>
                <td>
                    <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>

            <tr>
                <td>Monitores</td>
                <td>{{ $totalMonitors ?? 0 }}</td>
                <td>
                    <a href="{{ route('monitors.index') }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>

            <tr>
                <td>Horarios</td>
                <td>{{ $totalSchedules ?? 0 }}</td>
                <td>
                    <a href="{{ route('schedules.index') }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>

            <tr>
                <td>Sesiones</td>
                <td>{{ $totalSessions ?? 0 }}</td>
                <td>
                    <a href="{{ route('monitor_sessions.index') }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>

            <tr>
                <td>Asistencias</td>
                <td>{{ $totalAttendances ?? 0 }}</td>
                <td>
                    <a href="{{ route('attendances.index') }}" class="btn btn-info btn-sm">Ver</a>
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ÚLTIMAS ASISTENCIAS --}}
    <h4 class="text-light mt-4">Últimas asistencias</h4>

    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Sesión</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($recentAttendances ?? [] as $attendance)
                <tr>
                    <td>{{ $attendance->id }}</td>

                    <td>
                        {{ optional($attendance->user)->name ?? 'Sin usuario' }}
                    </td>

                    <td>
                        {{ $attendance->monitor_session_id }}
                    </td>

                    <td>
                        @if($attendance->asistio == 'present')
                            <span class="badge bg-success">Presente</span>
                        @elseif($attendance->asistio == 'absent')
                            <span class="badge bg-danger">Ausente</span>
                        @else
                            <span class="badge bg-warning text-dark">Justificado</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay registros</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection