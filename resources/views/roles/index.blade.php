@extends('layouts.panel')

@section('title', 'Roles')

@section('content')

<h2 class="text-light">Roles</h2>

<a href="{{ route('roles.create') }}" class="btn btn-success mb-3">
    Crear Rol
</a>

<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach($roles as $role)
        <tr>
            <td>{{ $role->id }}</td>
            <td>{{ $role->name }}</td>

            <td>

                {{-- EDITAR --}}
                <a href="{{ route('roles.edit', $role->id) }}"
                   class="btn btn-outline-primary btn-sm rounded-pill px-3">
                   Editar
                </a>

                {{-- ELIMINAR --}}
                <form action="{{ route('roles.destroy', $role->id) }}"
                      method="POST"
                      class="d-inline">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger btn-sm rounded-pill px-3"
                            onclick="return confirm('¿Eliminar rol?')">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection