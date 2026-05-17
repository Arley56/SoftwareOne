@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1 class="mb-4">Editar horario</h1>

        <form action="{{ route('schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Monitor --}}
            <div class="mb-3">
                <label for="monitor_id" class="form-label">Monitor</label>

                <select name="monitor_id" id="monitor_id" class="form-control" required>
                    <option value="">Seleccione un monitor</option>

                    @foreach($monitors as $monitor)
                        <option value="{{ $monitor->id }}" {{ $schedule->monitor_id == $monitor->id ? 'selected' : '' }}>

                            {{ $monitor->user->name ?? 'Sin nombre' }} - Sem {{ $monitor->semestre }}

                        </option>
                    @endforeach
                </select>
            </div>

                {{-- Día de la semana --}}
            <div class="mb-3">
                <label for="dia_semana" class="form-label">Día de la semana</label>

                <select name="dia_semana" id="dia_semana" class="form-control" required>
                    <option value="Lunes" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Lunes' ? 'selected' : '' }}>
                        Lunes
                    </option>

                    <option value="Martes" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Martes' ? 'selected' : '' }}>
                        Martes
                    </option>

                    <option value="Miércoles" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Miércoles' ? 'selected' : '' }}>
                        Miércoles
                    </option>

                    <option value="Jueves" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Jueves' ? 'selected' : '' }}>
                        Jueves
                    </option>

                    <option value="Viernes" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Viernes' ? 'selected' : '' }}>
                        Viernes
                    </option>

                    <option value="Sábado" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Sábado' ? 'selected' : '' }}>
                        Sábado
                    </option>

                    <option value="Domingo" {{ old('dia_semana', $schedule->dia_semana ?? '') == 'Domingo' ? 'selected' : '' }}>
                        Domingo
                    </option>
                </select>
            </div>

            {{-- Hora inicio --}}
            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora inicio</label>
                <input type="time" name="hora_inicio" id="hora_inicio" class="form-control"
                    value="{{ $schedule->hora_inicio }}" required>
            </div>

            {{-- Hora fin --}}
            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora fin</label>
                <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ $schedule->hora_fin }}"
                    required>
            </div>
            {{-- Modalidad --}}
            <div class="mb-3">
                <label for="modalidad" class="form-label">Modalidad</label>

                <select name="modalidad" id="modalidad" class="form-control" required>
                    <option value="" disabled>Seleccione una modalidad</option>
                    
                    <option value="Presencial"
                        {{ (old('modalidad', $schedule->modalidad) == 'Presencial') ? 'selected' : '' }}>
                        Presencial
                    </option>

                    <option value="Virtual"
                        {{ (old('modalidad', $schedule->modalidad) == 'Virtual') ? 'selected' : '' }}>
                        Virtual
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="salon" class="form-label">Salón</label>

                <input
                    type="text"
                    name="salon"
                    id="salon"
                    class="form-control"
                    value="{{ $schedule->salon }}"
                    placeholder="Ej: X104"
                >
            </div>
            
            <button type="submit" class="btn btn-success">
                Actualizar
            </button>

            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>
@endsection