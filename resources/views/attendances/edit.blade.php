@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1>Editar asistencia</h1>

        <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Usuario --}}
            <div class="mb-3">
                <label>Usuario</label>
                <select name="user_id" class="form-control" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $attendance->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sesión --}}
            <div class="mb-3">
                <label>Sesión</label>
                <select name="monitor_session_id" class="form-control" required>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}" {{ $attendance->monitor_session_id == $session->id ? 'selected' : '' }}>
                            Sesión #{{ $session->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Asistencia --}}
            <div class="mb-3">
                <label>Asistencia</label>
                <select name="asistio" class="form-control" required>
                    <option value="present" {{ $attendance->asistio == 'present' ? 'selected' : '' }}>
                        Presente
                    </option>
                    <option value="absent" {{ $attendance->asistio == 'absent' ? 'selected' : '' }}>
                        Ausente
                    </option>
                    <option value="justified" {{ $attendance->asistio == 'justified' ? 'selected' : '' }}>
                        Justificado
                    </option>
                </select>
            </div>

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection