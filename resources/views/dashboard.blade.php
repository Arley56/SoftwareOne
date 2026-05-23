<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning mb-4">{{ session('warning') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-4">{{ session('error') }}</div>
    @endif
    @if (session('info'))
        <div class="alert alert-info mb-4">{{ session('info') }}</div>
    @endif

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
                        <div>
                            <span class="badge text-bg-warning text-dark mb-3">Estudiante</span>
                            <h1 class="display-6 fw-bold mb-3">{{ __('Monitorías disponibles') }}</h1>
                            <p class="lead text-secondary mb-0">
                                {{ __('Explora las monitorías abiertas, aplica filtros y revisa la opción de inscripción visual.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @include('dashboard._sessions')
        </div>
    </div>
</x-app-layout>