<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Detalle de inscripción</h2>
    </x-slot>

    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h4 class="mb-0">Inscripción #{{ $sessionEnrollment->id }}</h4>
            @if ($sessionEnrollment->status === 'activa')
                <span class="badge text-bg-success">Activa</span>
            @else
                <span class="badge text-bg-secondary">Anulada</span>
            @endif
        </div>

        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Estudiante</h6>
                    <p class="mb-0">{{ $sessionEnrollment->user->name ?? 'Sin dato' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Monitoría</h6>
                    <p class="mb-0">{{ $sessionEnrollment->monitorSession->schedule->monitor->subject->name ?? 'Sin asignatura' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Monitor</h6>
                    <p class="mb-0">{{ $sessionEnrollment->monitorSession->schedule->monitor->user->name ?? 'Sin monitor' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Fecha de sesión</h6>
                    <p class="mb-0">{{ $sessionEnrollment->monitorSession->fecha ?? 'Sin fecha' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Horario</h6>
                    <p class="mb-0">{{ $sessionEnrollment->monitorSession->schedule->hora_inicio ?? '' }} - {{ $sessionEnrollment->monitorSession->schedule->hora_fin ?? '' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-1">Fecha de inscripción</h6>
                    <p class="mb-0">{{ optional($sessionEnrollment->enrolled_at)->format('Y-m-d H:i') ?? 'Sin registro' }}</p>
                </div>
            </div>
        </div>

        <div class="card-footer d-flex gap-2 flex-wrap">
            <a href="{{ route('session-enrollments.index') }}" class="btn btn-outline-light">Volver</a>

            @if ($sessionEnrollment->status === 'activa' && auth()->id() === $sessionEnrollment->user_id)
                <form method="POST" action="{{ route('session-enrollments.destroy', $sessionEnrollment->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('¿Deseas anular esta inscripción?')">
                        Anular inscripción
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
