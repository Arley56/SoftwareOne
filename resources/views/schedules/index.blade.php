@extends('layouts.panel')

@section('content')
<div class="container">
    <h1 class="mb-4">Horarios</h1>

    <a href="{{ route('schedules.create') }}" class="btn btn-primary mb-3">
        Crear nuevo horario
    </a>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Monitor</th>
                <th>Día de la semana</th>
                <th>Hora inicio</th>
                <th>Hora fin</th>
                <th>Modalidad</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->id }}</td>

                    <td>
                        {{ $schedule->monitor->user->name ?? 'Sin asignar' }}
                        <br>
                        <small>Semestre {{ $schedule->monitor->semestre ?? '' }}</small>
                    </td>

                    <td>
                        {{ $schedule->dia_semana }}
                    </td>

                    <td>{{ $schedule->hora_inicio }}</td>
                    <td>{{ $schedule->hora_fin }}</td>

                    <td>
                        <span class="badge bg-info text-dark">
                            {{ ucfirst($schedule->modalidad) }}
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-sm btn-info">
                            Ver
                        </a>

                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este horario?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        No hay horarios registrados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection