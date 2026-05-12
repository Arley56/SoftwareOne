@extends('layouts.panel')

@section('title', 'Usuarios')

@section('content')

    <h2 class="text-light">Usuarios</h2>

    <a href="{{route('users.create') }}" class="btn btn-success mb-3">
        Crear Usuarios
    </a>

    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->estado === 'activo')
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </td>
                    <td>

                        {{-- EDITAR --}}
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                            Editar
                        </a>

                        {{-- ELIMINAR --}}
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar usuario?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection