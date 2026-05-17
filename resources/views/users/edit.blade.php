@extends('layouts.panel')

@section('title', 'Editar Usuario')

@section('content')

    <h2 class="text-light mb-4">Editar Usuario</h2>

    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select" required>
                <option value="activo" {{ $user->estado == 'activo' ? 'selected' : '' }}>Activo</option>
                <option value="inactivo" {{ $user->estado == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">

            <label class="form-label">
                Foto actual
            </label>

            <br>

            @if($user->photo)

                <img
                    src="{{ asset('storage/' . $user->photo) }}"
                    width="120"
                    height="120"
                    class="rounded-circle mb-3"
                    style="object-fit: cover;"
                >

            @else

                <p class="text-secondary">
                    El usuario no tiene foto.
                </p>

            @endif

        </div>
        <div class="mb-3">

            <label class="form-label">
                Cambiar foto de perfil
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

        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </form>

@endsection