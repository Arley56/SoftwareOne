@extends('layouts.panel')

@section('title', 'Editar Materia')

@section('content')

    <h2 class="text-light mb-4">Editar Materia</h2>

    <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $subject->name }}" required>
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
                value="{{ old('code', $subject->code ?? '') }}"
                
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
                <option value="" disabled {{ old('credits', $subject->credits ?? '') == '' ? 'selected' : '' }}>
                    Selecciona la cantidad...
                </option>
                
                @for ($i = 1; $i <= 9; $i++)
                    <option value="{{ $i }}" {{ old('credits', $subject->credits ?? '') == $i ? 'selected' : '' }}>
                        {{ $i }} {{ $i == 1 ? 'Crédito' : 'Créditos' }}
                    </option>
                @endfor
            </select>
            
            {{-- Mensaje de error por si falla la validación --}}
            @error('credits')
                <div class="text-danger mt-1">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" placeholder="Ejemplo: Materia de matemáticas básica">{{ old('description', $subject->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Guardar Cambios
        </button>

        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
            Volver
        </a>

    </form>

@endsection