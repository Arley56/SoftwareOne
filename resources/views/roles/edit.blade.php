@extends('layouts.panel')

@section('title', 'Editar Roles')

@section('content')

    <h2 class="text-light mb-4">Editar Roles</h2>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
        </div>

        
        <button type="submit" class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </form>

@endsection