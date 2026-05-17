@extends('layouts.panel')

@section('title', 'Crear Usuario')

@section('content')

<h2 class="text-light mb-4">Crear Usuario</h2>

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input 
            type="text" 
            name="name" 
            class="form-control" 
            value="{{ old('name') }}"
            required>
        @error('name')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Correo</label>
        <input 
            type="email" 
            name="email" 
            class="form-control" 
            value="{{ old('email') }}"
            required>
        @error('email')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Rol del Usuario</label>
        <select name="role_id" class="form-control" required>
            <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Seleccione un rol...</option>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input 
            type="password" 
            name="password" 
            class="form-control" 
            required>
        @error('password')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-control" required>
            <option value="activo" {{ old('estado', 'activo') == 'activo' ? 'selected' : '' }}>Activo</option>
            <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('estado')
            <div class="text-danger mt-1">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">

        <label class="form-label">
            Foto de perfil
        </label>

        <input
            type="file"
            name="photo"
            class="form-control"
            accept=".jpg,.jpeg,.png"
        >

        @error('photo')
            <div class="text-danger mt-1">
                {{ $message }}
            </div>
        @enderror

    </div>

    <button type="submit" class="btn btn-success">
        Guardar Usuario
    </button>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        Volver
    </a>
</form>

@endsection