@extends('layouts.panel')

@section('title', 'Sesiones')

@section('content')

    <h2 class="text-light">Sesiones</h2>

    <a href="{{ route('monitor_sessions.create') }}" class="btn btn-success mb-3">
        Crear sesión
    </a>

    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Horario</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->id }}</td>

                    <td>
                        {{ $session->schedule->monitor->user->name ?? 'Sin monitor' }}
                        <br>
                        <small>
                            {{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}
                        </small>
                    </td>

                    <td>{{ $session->fecha }}</td>

                    <td>
                        <a href="{{ route('monitor_sessions.show', $session->id) }}" class="btn btn-info btn-sm">
                            Ver
                        </a>

                        <a href="{{ route('monitor_sessions.edit', $session->id) }}" class="btn btn-primary btn-sm">
                            Editar
                        </a>

                        <form action="{{ route('monitor_sessions.destroy', $session->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar sesión?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        No hay sesiones registradas
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>

@endsection