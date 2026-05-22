@extends('layouts.panel')

@section('title', 'Detalle sesión')

@section('content')

    <h2 class="text-light mb-4">Detalle de sesión</h2>

    <table class="table table-dark table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $session->id }}</td>
        </tr>

        <tr>
            <th>Monitor</th>
            <td>
                {{ $session->schedule->monitor->user->name ?? 'Sin monitor' }}
                <br>
                <small>Sem {{ $session->schedule->monitor->semestre ?? '' }}</small>
            </td>
        </tr>

        <tr>
            <th>Horario</th>
            <td>
                {{ $session->schedule->hora_inicio ?? '' }} - {{ $session->schedule->hora_fin ?? '' }}
            </td>
        </tr>

        <tr>
            <th>Día</th>
            <td>
                @switch($session->schedule->dia_semana ?? 0)
                    @case(1) Lunes @break
                    @case(2) Martes @break
                    @case(3) Miércoles @break
                    @case(4) Jueves @break
                    @case(5) Viernes @break
                    @case(6) Sábado @break
                    @case(7) Domingo @break
                    @default No definido
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
    </table>

    <a href="{{ route('monitor-sessions.index') }}" class="btn btn-secondary">
        Volver
    </a>

@endsection