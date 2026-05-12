@extends('layouts.panel')

@section('title', 'Detalle del horario')

@section('content')

    <div class="container">

        <h2 class="text-light mb-4">Detalle del horario</h2>

        <table class="table table-dark table-bordered">

            <tr>
                <th>ID</th>
                <td>{{ $schedule->id }}</td>
            </tr>

            <tr>
                <th>Monitor</th>
                <td>
                    {{ $schedule->monitor->user->name ?? 'Sin monitor' }}
                    <br>
                    <small>Sem {{ $schedule->monitor->semestre ?? '' }}</small>
                </td>
            </tr>

            <tr>
                <th>Día</th>
                <td>
                    @php
                        $dias = [
                            1 => 'Lunes',
                            2 => 'Martes',
                            3 => 'Miércoles',
                            4 => 'Jueves',
                            5 => 'Viernes',
                            6 => 'Sábado',
                            7 => 'Domingo'
                        ];
                    @endphp

                    {{ $dias[$schedule->dia_semana] ?? 'No definido' }}
                </td>
            </tr>

            <tr>
                <th>Horario</th>
                <td>
                    {{ $schedule->hora_inicio }} - {{ $schedule->hora_fin }}
                </td>
            </tr>

            <tr>
                <th>Modalidad</th>
                <td>
                    @if($schedule->modalidad == 'presencial')
                        <span class="badge bg-primary">Presencial</span>
                    @else
                        <span class="badge bg-success">Virtual</span>
                    @endif
                </td>
            </tr>

        </table>

        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </div>

@endsection