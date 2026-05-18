@extends('layouts.panel')

@section('title', 'Editar Monitor')

@section('content')

    <h2 class="text-light mb-4">Editar Monitor</h2>

    <form action="{{ route('monitors.update', $monitor->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Usuario --}}
        <div class="mb-3">
            <label for="user_id" class="form-label fw-bold">
                Usuario
            </label>

            <select name="user_id" class="form-select" required>
                <option value="" disabled {{ old('user_id', $monitor->user_id ?? '') == '' ? 'selected' : '' }}>
                    Selecciona un usuario...
                </option>

                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $monitor->user_id ?? '') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Materia --}}
        <div class="mb-3">
            <label for="subject_id" class="form-label fw-bold">
                Materia
            </label>

            <select name="subject_id" class="form-select" required>
                <option value="" disabled {{ old('subject_id', $monitor->subject_id ?? '') == '' ? 'selected' : '' }}>
                    Selecciona una asignatura...
                </option>

                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id', $monitor->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Semestre --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                Semestre
            </label>

            <select name="semestre_monitor" class="form-select" required>
                <option value="" disabled {{ old('semestre_monitor', $monitor->semestre ?? '') == '' ? 'selected' : '' }}>
                    Selecciona un semestre...
                </option>

                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('semestre_monitor', $monitor->semestre ?? '') == $i ? 'selected' : '' }}>
                        Semestre {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        {{-- NUEVO CAMPO: DESCRIPCIÓN --}}
        <div class="mb-4">
            <label for="description" class="form-label fw-bold">
                Descripción del monitor
            </label>

            <textarea name="description" class="form-control" rows="4" maxlength="1000"
                placeholder="Escribe una breve descripción del monitor...">{{ old('description', $monitor->description ?? '') }}</textarea>

            <small class="text-muted">
                Máximo 1000 caracteres.
            </small>
        </div>

        {{-- Botones --}}
        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('monitors.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </form>

@endsection