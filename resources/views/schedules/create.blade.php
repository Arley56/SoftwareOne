@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1 class="mb-4">Crear Horario</h1>

        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf

            @if(Auth::user()->role_id == 1)
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

            @elseif(Auth::user()->role_id == 2)
                <input type="hidden" name="monitor_id" value="{{ $monitorActual->id }}">
                <div class="mb-3">
                    <label>Monitor</label>
                    <input type="text" class="form-control" value="{{ $monitorActual->user->name }}" disabled>
                </div>
            @endif

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

            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="modalidad" class="form-label">Modalidad</label>
                <select name="modalidad" id="modalidad" class="form-control" required>
                    <option value="">Seleccione modalidad</option>
                    <option value="Presencial">Presencial</option>
                    <option value="Virtual">Virtual</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="salon" class="form-label">Salón</label>
                <input type="text" name="salon" id="salon" class="form-control" placeholder="Ej: X104">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Cancelar</a>

        </form>
    </div>
@endsection