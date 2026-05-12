@extends('layouts.panel')

@section('title', 'Crear Roles')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">

                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Crear Roles</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                required
                            >

                            @error('name')
                                <div class="text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex gap-3 justify-content-center mt-5">

                            <button
                                type="submit"
                                class="btn btn-success btn-lg px-5 rounded-pill shadow-sm fw-bold d-flex align-items-center">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     width="18"
                                     height="18"
                                     fill="currentColor"
                                     class="bi bi-check-circle me-2"
                                     viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                                </svg>

                                Guardar Rol
                            </button>

                            <button
                                type="button"
                                class="btn btn-outline-secondary btn-lg px-5 rounded-pill fw-bold"
                                onclick="window.history.back()">

                                Cancelar
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection