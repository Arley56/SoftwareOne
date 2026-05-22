@extends('layouts.panel')

@section('title', 'Editar sesión')

@section('content')

    <h2 class="text-light mb-4">Editar sesión</h2>

    <form action="{{ route('monitor-sessions.update', $session->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- HORARIO --}}
        <div class="mb-3">
            <label class="text-light">Horario</label>
            <select name="schedule_id" class="form-control" required>
                <option value="">Seleccione un horario</option>

                @foreach($schedules as $schedule)
                    <option value="{{ $schedule->id }}" {{ $session->schedule_id == $schedule->id ? 'selected' : '' }}>

                        {{ $schedule->monitor->user->name ?? 'Sin monitor' }}
                        - {{ $schedule->hora_inicio }} a {{ $schedule->hora_fin }}

                    </option>
                @endforeach
            </select>
        </div>

        {{-- FECHA --}}
        <div class="mb-3">
            <label class="text-light">Fecha</label>
            <input type="date" name="fecha" value="{{ $session->fecha }}" class="form-control" required>
        </div>

        {{-- BOTONES --}}
        <button class="btn btn-primary">Actualizar</button>

        <a href="{{ route('monitor-sessions.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>

@endsection