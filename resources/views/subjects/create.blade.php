@extends('layouts.panel')

@section('title', 'Crear Materia')

@section('content')

    <h2 class="text-light mb-4">Crear Materia</h2>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" required placeholder="Ejemplo: Matemáticas I">
        </div>

        <div class="mb-3">
            <label class="form-label">Código</label>

            <input
                type="text"
                name="code"
                class="form-control"
                required
                pattern="[A-Z]{3}[0-9]{3}"
                title="El código debe tener 3 letras mayúsculas y 3 números. Ejemplo: MAT101"
                placeholder="Ejemplo: MAT101"
            >
            @error('code')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Créditos</label>
            <select name="credits" class="form-select" required>
                <option value="" disabled {{ old('credits', $monitor->credits ?? '') == '' ? 'selected' : '' }}>
                    Selecciona la cantidad...
                </option>
                
                @for ($i = 1; $i <= 9; $i++)
                    <option value="{{ $i }}" {{ old('credits', $monitor->credits ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }} {{ $i == 1 ? 'Crédito' : 'Créditos' }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" placeholder="Ejemplo: Materia de matemáticas básica"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            Crear Materia
        </button>

        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </form>

@endsection