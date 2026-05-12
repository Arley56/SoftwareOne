@extends('layouts.panel')

@section('title', 'Subjects')

@section('content')

    <h2 class="text-light mb-4">Materias</h2>

    <a href="{{ route('subjects.create') }}" class="btn btn-success mb-3">
        Crear Materia
    </a>

    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Creditos</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($subjects as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->credits }}</td>
                    <td>{{ $subject->description }}</td>

                    <td class="align-middle">
                        <div class="d-flex gap-2">
                            <a href="{{ route('subjects.edit', $subject->id) }}" 
                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>

                            <form action="{{ route('subjects.destroy', $subject->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('¿Estás seguro de eliminar esta asignatura?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection