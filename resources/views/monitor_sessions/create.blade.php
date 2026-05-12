@extends('layouts.panel')

@section('title', 'Crear sesión')

@section('content')

    <h2 class="text-light mb-4">Crear sesión</h2>

    <form action="{{ route('monitor_sessions.store') }}" method="POST">
        @csrf

        {{-- HORARIO --}}
        <div class="mb-3">
            <label class="text-light">Horario</label>
            <select name="schedule_id" class="form-control" required>
                <option value="">Seleccione horario</option>

                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}">
                        {{ $schedule->monitor->user->name ?? 'Sin monitor' }}
                        - {{ $schedule->hora_inicio }} a {{ $schedule->hora_fin }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- FECHA --}}
        <div class="mb-3">
            <label class="text-light">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        {{-- BOTONES --}}
        <button class="btn btn-success">Guardar</button>

        <a href="{{ route('monitor_sessions.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>

@endsection