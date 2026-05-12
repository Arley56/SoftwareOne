@extends('layouts.panel')

@section('title', 'Crear Monitor')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h4 class="mb-0">Crear Monitor</h4>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('monitors.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-bold">Usuario</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="" selected disabled>Seleccione un usuario</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject_id" class="form-label fw-bold">Materia</label>
                            <select name="subject_id" id="subject_id" class="form-select" required>
                                <option value="" selected disabled>Seleccione una materia</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Semestre</label>
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

                    <div class="d-flex gap-3 justify-content-center mt-5">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm fw-bold d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-circle me-2" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05"/>
                            </svg>
                            Guardar Monitor
                        </button>

                        <button type="button" class="btn btn-outline-secondary btn-lg px-5 rounded-pill fw-bold" onclick="window.history.back()">
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