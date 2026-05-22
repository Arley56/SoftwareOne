<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-lg-5">
                    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
                        <div>
                            <span class="badge text-bg-primary mb-3">Panel por defecto</span>
                            <h1 class="display-6 fw-bold mb-3">{{ __("You're logged in!") }}</h1>
                            <p class="lead text-secondary mb-0">
                                {{ __('Desde aquí puedes navegar por el sistema según tu rol.') }}
                            </p>
                        </div>

                        <div class="d-grid gap-2 min-w-0">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Editar perfil</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">Refrescar dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
