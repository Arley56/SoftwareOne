@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1 class="mb-4">Crear horario</h1>

        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf

            {{-- Monitor --}}
            <div class="mb-3">
                <label>Monitor</label>

                <select name="monitor_id" class="form-control" required>
                    <option value="">Seleccione monitor</option>

                    @foreach($monitors as $monitor)
                        <option value="{{ $monitor->id }}">
                            {{ $monitor->user->name ?? 'Sin nombre' }} - Semestre {{ $monitor->semestre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Día de la semana --}}
            <div class="mb-3">
                <label for="dia_semana" class="form-label">Día de la semana</label>
                <select name="dia_semana" id="dia_semana" class="form-control" required>
                    <option value="">Seleccione un día</option>
                    <option>Lunes</option>
                    <option>Martes</option>
                    <option>Miércoles</option>
                    <option>Jueves</option>
                    <option>Viernes</option>
                    <option>Sábado</option>
                    <option>Domingo</option>
                </select>
            </div>

            {{-- Hora inicio --}}
            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>

            {{-- Hora fin --}}
            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
            </div>

            {{-- Modalidad --}}
            <div class="mb-3">
                <label for="modalidad" class="form-label">Modalidad</label>
                <select name="modalidad" id="modalidad" class="form-control" required>
                    <option value="">Seleccione modalidad</option>
                    <option value="presencial">Presencial</option>
                    <option value="virtual">Virtual</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Guardar
            </button>

            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>
@endsection