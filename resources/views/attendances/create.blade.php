@extends('layouts.panel')

@section('content')
    <div class="container">
        <h1>Registrar asistencia</h1>

        <form action="{{ route('attendances.store') }}" method="POST">
            @csrf

            {{-- Usuario --}}
            <div class="mb-3">
                <label class="form-label">Usuario</label>

                <select name="user_id" class="form-control" required>
                    <option value="">Seleccione usuario</option>

                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sesión --}}
            <div class="mb-3">
                <label class="form-label">Sesión</label>

                <select name="monitor_session_id" class="form-control" required>
                    <option value="">Seleccione sesión</option>

                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">
                            Sesión #{{ $session->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Asistencia --}}
            <div class="mb-3">
                <label class="form-label">Asistencia</label>

                <select name="asistio" class="form-control" required>
                    <option value="">Seleccione estado</option>
                    <option value="present">Presente</option>
                    <option value="absent">Ausente</option>
                    <option value="justified">Justificado</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">
                Guardar
            </button>

            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </form>
    </div>
@endsection